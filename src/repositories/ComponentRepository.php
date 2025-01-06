<?php


require_once 'Repository.php';
require_once 'UserRepository.php';
require_once 'src/models/Component.php';
require_once 'src/models/User.php';
require_once 'src/models/Tag.php';
require_once 'src/utilities/Validator.php';

class ComponentRepository extends Repository
{
    private static ?ComponentRepository $instance = null;

    public static function getInstance(): ComponentRepository
    {
        if (self::$instance === null) {
            self::$instance = new ComponentRepository();
        }
        return self::$instance;
    }

    public function getTags(int $componentID): array
    {
        $query = 'SELECT tagid FROM public."ComponentTag" WHERE componentid = :id';
        $stmt = $this->database->connect()->prepare($query);
        $stmt->bindParam(':id', $componentID, PDO::PARAM_INT);
        $stmt->execute();
        $tagsIdList = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

        $tags = [];
        if (!$tagsIdList) {
            return $tags;
        }

        $query = 'SELECT * FROM public."Tag" JOIN public."Color" USING (colorid) WHERE tagid = :id';
        foreach ($tagsIdList as $tagId) {
            $stmt = $this->database->connect()->prepare($query);
            $stmt->bindParam(':id', $tagId, PDO::PARAM_INT);
            $stmt->execute();
            $tag = $stmt->fetch(PDO::FETCH_ASSOC);
            $tags[] = new Tag($tag['tagid'], $tag['name'], $tag['hex']);
        }
        return $tags;
    }

    public function likeComponent($componentID, $userID): void
    {
        $query = 'INSERT INTO public."Likes" (componentid, userid) VALUES (:componentid, :userid)';
        $stmt = $this->database->connect()->prepare($query);
        $stmt->bindParam(':componentid', $componentID, PDO::PARAM_INT);
        $stmt->bindParam(':userid', $userID, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function unlikeComponent($componentID, $userID): void
    {
        $query = 'DELETE FROM public."Likes" WHERE componentid = :componentid AND userid = :userid';
        $stmt = $this->database->connect()->prepare($query);
        $stmt->bindParam(':componentid', $componentID, PDO::PARAM_INT);
        $stmt->bindParam(':userid', $userID, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function isLikedComponent($componentID, $userID): bool
    {
        $query = 'SELECT * FROM public."Likes" WHERE componentid = :componentid AND userid = :userid';
        $stmt = $this->database->connect()->prepare($query);
        $stmt->bindParam(':componentid', $componentID, PDO::PARAM_INT);
        $stmt->bindParam(':userid', $userID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function getComponents(string $sorting = 'Newest', array $filters = ['Buttons', 'Inputs', 'Checkboxes', 'Radio buttons'], string $search = ''): array
    {
        $sortingQuery = '';
        switch ($sorting) {
            case 'Newest':
                $sortingQuery = 'ORDER BY "Component".createdat DESC';
                break;
            case 'Oldest':
                $sortingQuery = 'ORDER BY "Component".createdat ASC';
                break;
            case 'Most likes':
            default:
                $sortingQuery = 'ORDER BY (SELECT count(*) FROM public."Likes" WHERE componentid = "Component".componentid) DESC';
                break;
        }

        $filterMap = [
            'Buttons' => 'button',
            'Inputs' => 'input',
            'Checkboxes' => 'checkbox',
            'Radio buttons' => 'radio button'
        ];

        $mappedFilters = array_map(function ($filter) use ($filterMap) {
            return $filterMap[$filter] ?? $filter;
        }, $filters);

        $filters = $mappedFilters;

        $filterQuery = '';
        if (!empty($filters)) {
            $filterPlaceholders = implode(',', array_fill(0, count($filters), '?'));
            $filterQuery = 'AND "Type".name IN (' . $filterPlaceholders . ')';
        }

        $searchQuery = '';
        if (!empty($search)) {
            $searchQuery = 'AND "Component".name ILIKE ? OR "Set".name ILIKE ? or "User".nickname ILIKE ?';
        }

        $query = '
        SELECT
            "Component".componentid,
            "Component".name,
            "Component".css,
            "Component".html,
            "Component".authorid,
            "User".nickname,
            "Color".hex,
            "Type".name as typename,
            "Set".name as setname
        FROM public."Component"
            LEFT JOIN public."Color" USING (colorid)
            LEFT JOIN public."Set" USING (setid)
            LEFT JOIN public."Type" USING (typeid)
            LEFT JOIN public."User" ON "Component".authorid = "User".userid
        WHERE 1=1 ' . $filterQuery . ' ' . $searchQuery . ' ' . $sortingQuery;

        $stmt = $this->database->connect()->prepare($query);
        $paramIndex = 1;
        foreach ($filters as $filter) {
            $stmt->bindValue($paramIndex++, $filter);
        }
        if (!empty($search)) {
            $stmt->bindValue($paramIndex++, '%' . $search . '%');
            $stmt->bindValue($paramIndex++, '%' . $search . '%');
            $stmt->bindValue($paramIndex, '%' . $search . '%');
        }
        $stmt->execute();
        $componentList = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $components = [];
        foreach ($componentList as $component) {
            $likes = $this->getComponentLikes($component['componentid']);
            $components[] = new Component(
                $component['name'],
                $component['setname'],
                $component['typename'],
                $component['hex'],
                $this->getTags($component['componentid']),
                $likes,
                $component['css'],
                $component['html'],
                UserRepository::getInstance()->getUserById($component['authorid']),
                $component['componentid']
            );
        }
        return $components;
    }

    public function getComponentById(int $id): ?Component
    {
        $query = '
            SELECT
                "Component".componentid,
                "Component".name,
                "Component".css,
                "Component".html,
                "Component".authorid,
                "Color".hex,
                "Type".name as typename,
                "Set".name as setname
            FROM public."Component"
                LEFT JOIN public."Color" USING (colorid)
                LEFT JOIN public."Set" USING (setid)
                LEFT JOIN public."Type" USING (typeid)
            WHERE componentid = :id
        ';
        $stmt = $this->database->connect()->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $component = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$component) {
            return null;
        }

        return new Component(
            $component['name'],
            $component['setname'],
            $component['typename'],
            $component['hex'],
            $this->getTags($component['componentid']),
            $this->getComponentLikes($component['componentid']),
            $component['css'],
            $component['html'],
            UserRepository::getInstance()->getUserById($component['authorid']),
            $component['componentid']
        );
    }

    private function getComponentLikes(int $componentId): int
    {
        $query = 'SELECT count(*) FROM public."Likes" WHERE componentid = :id';
        $stmt = $this->database->connect()->prepare($query);
        $stmt->bindParam(':id', $componentId, PDO::PARAM_INT);
        $stmt->execute();
        return (int)$stmt->fetch(PDO::FETCH_ASSOC)['count'];
    }

    public function createComponent(string $name, string $type, string $set, string $color, array $tags, int $userID, string $css, string $html): void
    {
        $name = Validator::check_input($name);
        $type = Validator::check_input($type);
        $set = Validator::check_input($set);
        $color = Validator::check_input(substr($color, 1));
        $css = Validator::check_input($css);
        $html = Validator::check_input($html);
        if (
            !$name || !$type || !$set || !$color || !$css || !$html) {
            ErrorController::getInstance()->error404();
        }

        $query = 'SELECT typeid FROM public."Type" WHERE name = :type';
        $stmt = $this->database->connect()->prepare($query);
        $stmt->bindParam(':type', $type, PDO::PARAM_STR);
        $stmt->execute();
        $typeId = $stmt->fetch(PDO::FETCH_ASSOC)['typeid'];
        if (!$typeId) {
            throw new Exception('Type not found');
        }

        $query = 'SELECT setid FROM public."Set" WHERE name = :set';
        $stmt = $this->database->connect()->prepare($query);
        $stmt->bindParam(':set', $set, PDO::PARAM_STR);
        $stmt->execute();
        $setId = $stmt->fetch(PDO::FETCH_ASSOC)['setid'];
        if (!$setId) {
            throw new Exception('Set not found');
        }

        $query = 'SELECT colorid FROM public."Color" WHERE hex = :color';
        $stmt = $this->database->connect()->prepare($query);
        $stmt->bindParam(':color', $color, PDO::PARAM_STR);
        $stmt->execute();
        $colorId = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$colorId) {
            $query = 'INSERT INTO public."Color" (hex) VALUES (:color) RETURNING colorid';
            $stmt = $this->database->connect()->prepare($query);
            $stmt->bindParam(':color', $color, PDO::PARAM_STR);
            $stmt->execute();
            $colorId = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        $colorId = $colorId['colorid'];
        if (!$colorId) {
            throw new Exception('Color not found');
        }

        $query = 'INSERT INTO public."Component" (name, typeid, setid, colorid, authorid, css, html) 
                    VALUES (?, ?, ?, ?, ?, ?, ?) RETURNING componentid';
        $stmt = $this->database->connect()->prepare($query);
        if (
            $stmt->execute([$name, $typeId, $setId, $colorId, $userID, $css, $html])
        ) {
            $componentID = $stmt->fetch(PDO::FETCH_ASSOC)['componentid'];
            $this->addTags($tags, $componentID);
        } else {
            throw new Exception('Failed to create component');
        }
    }

    private function addTags(array $tags, int $componentID): void
    {
        $queryTagID = 'SELECT tagid FROM public."Tag" WHERE name = :name';
        $queryInsertComponentTag = 'INSERT INTO public."ComponentTag" (componentid, tagid) VALUES (:component, :tag)';
        foreach ($tags as $tag) {
            $tag = Validator::check_input($tag);
            if (!$tag) {
                ErrorController::getInstance()->error404();
            }
            $stmt = $this->database->connect()->prepare($queryTagID);
            $stmt->bindParam(':name', $tag, PDO::PARAM_STR);
            $stmt->execute();
            $tagID = $stmt->fetch(PDO::FETCH_ASSOC)['tagid'];
            if ($tagID) {
                $stmt = $this->database->connect()->prepare($queryInsertComponentTag);
                $stmt->bindParam(':component', $componentID, PDO::PARAM_INT);
                $stmt->bindParam(':tag', $tagID, PDO::PARAM_INT);
                $stmt->execute();
            }
        }
    }
}