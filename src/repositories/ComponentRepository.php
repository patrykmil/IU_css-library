<?php

require_once 'Repository.php';
require_once 'UserRepository.php';
require_once 'src/models/Component.php';
require_once 'src/models/User.php';
require_once 'src/models/Tag.php';
require_once 'src/models/Message.php';
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
        $query = '
            SELECT tagid, name, hex
            FROM public."ComponentTagsView"
            WHERE componentid = :id
        ';
        $conn = $this->database->connect();
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $componentID, PDO::PARAM_INT);
        $stmt->execute();
        $tagsData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->database->disconnect($conn);

        $tags = [];
        foreach ($tagsData as $tag) {
            $tags[] = new Tag($tag['tagid'], $tag['name'], $tag['hex']);
        }
        return $tags;
    }

    private function generateSortingQuery(string $sorting): string
    {
        return match ($sorting) {
            'Newest' => 'ORDER BY createdat DESC',
            'Oldest' => 'ORDER BY createdat ASC',
            default => 'ORDER BY likes DESC',
        };
    }

    private function generateFilterQuery(array $filters): array
    {
        $filterMap = [
            'Buttons' => 'button',
            'Inputs' => 'input',
            'Checkboxes' => 'checkbox',
            'Radio buttons' => 'radio button'
        ];

        $mappedFilters = array_map(function ($filter) use ($filterMap) {
            return $filterMap[$filter] ?? $filter;
        }, $filters);

        $filterQuery = '';
        if (!empty($mappedFilters)) {
            $filterPlaceholders = implode(',', array_fill(0, count($mappedFilters), '?'));
            $filterQuery = 'AND typename IN (' . $filterPlaceholders . ')';
        }

        return [$filterQuery, $mappedFilters];
    }

    private function generateSearchQuery(string $search): string
    {
        if (!empty($search)) {
            return 'AND (name ILIKE ? OR setname ILIKE ? OR nickname ILIKE ?)';
        }
        return '';
    }

    private function fetchComponents(string $query, array $filters, string $search): array
    {
        $conn = $this->database->connect();
        $stmt = $conn->prepare($query);
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
        $components = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->database->disconnect($conn);
        return $components;
    }

    public function getComponents(string $sorting = 'Most likes', array $filters = ['Buttons', 'Inputs', 'Checkboxes', 'Radio buttons'], string $search = ''): array
    {
        $sortingQuery = $this->generateSortingQuery($sorting);
        $searchQuery = $this->generateSearchQuery($search);
        list($filterQuery, $filters) = $this->generateFilterQuery($filters);

        $query = '
            SELECT
                componentid,
                name,
                css,
                html,
                authorid,
                nickname,
                hex,
                typename,
                setname,
                likes
            FROM public."ComponentDetailsView"
            WHERE 1=1 ' . $filterQuery . ' ' . $searchQuery . ' ' . $sortingQuery;

        $componentList = $this->fetchComponents($query, $filters, $search);

        $components = [];
        foreach ($componentList as $component) {
            $components[] = new Component(
                $component['name'],
                $component['setname'],
                $component['typename'],
                $component['hex'],
                $this->getTags($component['componentid']),
                $component['likes'],
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
            componentid,
            name,
            css,
            html,
            authorid,
            nickname,
            hex,
            typename,
            setname,
            likes
        FROM public."ComponentDetailsView"
        WHERE componentid = :id
    ';
        $conn = $this->database->connect();
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $component = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->database->disconnect($conn);

        if (!$component) {
            return null;
        }

        return new Component(
            $component['name'],
            $component['setname'],
            $component['typename'],
            $component['hex'],
            $this->getTags($component['componentid']),
            $component['likes'],
            $component['css'],
            $component['html'],
            UserRepository::getInstance()->getUserById($component['authorid']),
            $component['componentid']
        );
    }

    /**
     * @throws Exception
     */
    private function getTypeId(string $type): int
    {
        $query = 'SELECT typeid FROM public."Type" WHERE name = :type';
        $conn = $this->database->connect();
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':type', $type);
        $stmt->execute();
        $typeId = $stmt->fetch(PDO::FETCH_ASSOC)['typeid'];
        $this->database->disconnect($conn);
        if (!$typeId) {
            throw new Exception('Type not found');
        }
        return $typeId;
    }

    /**
     * @throws Exception
     */
    private function getSetId(string $set): int
    {
        $query = 'SELECT setid FROM public."Set" WHERE name = :set';
        $conn = $this->database->connect();
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':set', $set);
        $stmt->execute();
        $setId = $stmt->fetch(PDO::FETCH_ASSOC)['setid'];
        $this->database->disconnect($conn);
        if (!$setId) {
            throw new Exception('Set not found');
        }
        return $setId;
    }

    /**
     * @throws Exception
     */
    private function getColorId(string $color): int
    {
        $query = 'SELECT colorid FROM public."Color" WHERE hex = :color';
        $conn = $this->database->connect();
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':color', $color);
        $stmt->execute();
        $colorId = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->database->disconnect($conn);
        if (!$colorId) {
            $query = 'INSERT INTO public."Color" (hex) VALUES (:color) RETURNING colorid';
            $conn = $this->database->connect();
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':color', $color);
            $stmt->execute();
            $colorId = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->database->disconnect($conn);
        }
        $colorId = $colorId['colorid'];
        if (!$colorId) {
            throw new Exception('Color not found');
        }
        return $colorId;
    }

    /**
     * @throws Exception
     */
    public function addComponent(string $name, string $type, string $set, string $color, array $tags, int $userID, string $css, string $html): int
    {
        $name = Validator::check_input($name);
        $type = Validator::check_input($type);
        $set = Validator::check_input($set);
        $color = strtoupper(Validator::check_input(substr($color, 1)));
        $css = Validator::check_input($css);
        $html = Validator::check_input($html);

        if (!$name || !$type || !$set || !$color || !$css || !$html) {
            throw new Exception('Invalid input');
        }

        $conn = $this->database->connect();
        try {
            $conn->beginTransaction();

            $typeId = $this->getTypeId($type);
            $setId = $this->getSetId($set);
            $colorId = $this->getColorId($color);

            $query = 'INSERT INTO public."Component" (name, typeid, setid, colorid, authorid, css, html) 
                VALUES (?, ?, ?, ?, ?, ?, ?) RETURNING componentid';
            $stmt = $conn->prepare($query);
            if ($stmt->execute([$name, $typeId, $setId, $colorId, $userID, $css, $html])) {
                $componentID = $stmt->fetch(PDO::FETCH_ASSOC)['componentid'];
                $this->addTags($tags, $componentID, $conn);
            } else {
                throw new Exception('Failed to create component');
            }

            $conn->commit();
        } catch (Exception $e) {
            $conn->rollBack();
            throw $e;
        } finally {
            $this->database->disconnect($conn);
        }

        return $componentID;
    }

    /**
     * @throws Exception
     */
    private function addTags(array $tags, int $componentID, PDO $conn): void
    {
        $queryTagID = 'SELECT tagid FROM public."Tag" WHERE name = :name';
        $queryInsertComponentTag = 'INSERT INTO public."ComponentTag" (componentid, tagid) VALUES (:component, :tag)';
        foreach ($tags as $tag) {
            $tag = Validator::check_input($tag);
            if (!$tag) {
                throw new Exception('Invalid tag');
            }
            $stmt = $conn->prepare($queryTagID);
            $stmt->bindParam(':name', $tag);
            $stmt->execute();
            $tagID = $stmt->fetch(PDO::FETCH_ASSOC)['tagid'];
            if ($tagID) {
                $stmt = $conn->prepare($queryInsertComponentTag);
                $stmt->bindParam(':component', $componentID, PDO::PARAM_INT);
                $stmt->bindParam(':tag', $tagID, PDO::PARAM_INT);
                if (!$stmt->execute()) {
                    throw new Exception('Failed to insert component tag');
                }
            } else {
                throw new Exception('Tag not found');
            }
        }
    }

    public function likeComponent(int $componentID, int $userID): void
    {
        $query = 'INSERT INTO public."Likes" (componentid, userid) VALUES (:componentid, :userid)';
        $conn = $this->database->connect();
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':componentid', $componentID, PDO::PARAM_INT);
        $stmt->bindParam(':userid', $userID, PDO::PARAM_INT);
        $stmt->execute();
        $this->database->disconnect($conn);
    }

    public function unlikeComponent(int $componentID, int $userID): void
    {
        $query = 'DELETE FROM public."Likes" WHERE componentid = :componentid AND userid = :userid';
        $conn = $this->database->connect();
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':componentid', $componentID, PDO::PARAM_INT);
        $stmt->bindParam(':userid', $userID, PDO::PARAM_INT);
        $stmt->execute();
        $this->database->disconnect($conn);
    }

    public function isLikedComponent(int $componentID, int $userID): bool
    {
        $query = 'SELECT * FROM public."Likes" WHERE componentid = :componentid AND userid = :userid';
        $conn = $this->database->connect();
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':componentid', $componentID, PDO::PARAM_INT);
        $stmt->bindParam(':userid', $userID, PDO::PARAM_INT);
        $stmt->execute();
        $row_count = $stmt->rowCount() > 0;
        $this->database->disconnect($conn);
        return $row_count;
    }

    private function getComponentLikes(int $componentId): int
    {
        $query = 'SELECT count(*) FROM public."Likes" WHERE componentid = :id';
        $conn = $this->database->connect();
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $componentId, PDO::PARAM_INT);
        $stmt->execute();
        $likes = (int)$stmt->fetch(PDO::FETCH_ASSOC)['count'];
        $this->database->disconnect($conn);
        return $likes;
    }

    public function getLikedComponents(int $userID): array
    {
        $query = 'SELECT componentid FROM public."Likes" WHERE userid = :id';
        $conn = $this->database->connect();
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $userID, PDO::PARAM_INT);
        $stmt->execute();
        $componentIDs = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
        $this->database->disconnect($conn);
        $components = [];
        foreach ($componentIDs as $componentID) {
            $components[] = $this->getComponentById($componentID);
        }
        return $components;
    }

    public function getOwnedComponents(int $userID): array
    {
        $query = 'SELECT setid, name FROM public."Set" WHERE ownerid = :id';
        $conn = $this->database->connect();
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $userID, PDO::PARAM_INT);
        $stmt->execute();
        $sets = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->database->disconnect($conn);
        $components = [];
        foreach ($sets as $set) {
            $query = 'SELECT componentid FROM public."Component" WHERE setid = :id';
            $conn = $this->database->connect();
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id', $set['setid'], PDO::PARAM_INT);
            $stmt->execute();
            $componentIDs = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
            $this->database->disconnect($conn);
            $tempComp = [];
            foreach ($componentIDs as $componentID) {
                $tempComp[] = $this->getComponentById($componentID);
            }
            $components[] = ['name' => $set['name'], 'components' => $tempComp];
        }
        return $components;
    }

    public function deleteComponent(int $componentID): void
    {
        $query = 'DELETE FROM public."Component" WHERE componentid = :id';
        $conn = $this->database->connect();
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $componentID, PDO::PARAM_INT);
        $stmt->execute();
        $this->database->disconnect($conn);
    }

    public function adminDeleteComponent(int $componentID, int $messageID): void
    {
        $query = 'CALL public."admin_delete_component"(:componentid, :messageid)';
        $conn = $this->database->connect();
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':messageid', $messageID, PDO::PARAM_INT);
        $stmt->bindParam(':componentid', $componentID, PDO::PARAM_INT);
        $stmt->execute();
        $this->database->disconnect($conn);
    }

    public function getMessages()
    {
        $query = 'SELECT * FROM public."Message"';
        $conn = $this->database->connect();
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->database->disconnect($conn);
        $messageObjects = [];
        foreach ($messages as $message) {
            $messageObjects[] = new Message($message['messageid'], $message['name'], $message['description']);
        }
        return $messageObjects;
    }
}