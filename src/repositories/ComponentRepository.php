<?php

require_once 'Repository.php';
require_once 'UserRepository.php';
require_once 'src/models/Component.php';
require_once 'src/models/User.php';
require_once 'src/models/Tag.php';

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

    public function getComponents(): array
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
        ';
        $stmt = $this->database->connect()->prepare($query);
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
}