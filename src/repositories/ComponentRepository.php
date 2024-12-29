<?php

require_once 'Repository.php';
require_once 'UserRepository.php';
require_once 'src/models/Component.php';
require_once 'src/models/User.php';
require_once 'src/models/Tag.php';


class ComponentRepository extends Repository
{
    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new ComponentRepository();
        }
        return self::$instance;
    }

    public function getTags(int $componentID): array
    {
        $stmt = $this->database->connect()->prepare('
            SELECT tagid FROM public."ComponentTag" WHERE componentid = :id');
        $stmt->bindParam(':id', $componentID, PDO::PARAM_INT);
        $stmt->execute();
        $tagIdList = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
        $tags = [];
        foreach ($tagIdList as $tagId) {
            $stmt = $this->database->connect()->prepare('
                SELECT * FROM public."Tag" JOIN public."Color" USING (colorid) WHERE tagid = :id');
            $stmt->bindParam(':id', $tagId, PDO::PARAM_INT);
            $stmt->execute();
            $tag = $stmt->fetch(PDO::FETCH_ASSOC);
            $tags[] = new Tag($tag['tagid'], $tag['name'], $tag['hex']);
        }
        return $tags;
    }

    public function getComponents(): array
    {
        $stmt = $this->database->connect()->prepare('
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
                left join public."Color" using (colorid) 
                left join public."Set" using (setid) 
                left join public."Type" using (typeid)
                ');
        $stmt->execute();
        $componentList = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $components = [];
        foreach ($componentList as $component) {
            $likes = 0;
            $stmt = $this->database->connect()->prepare('
            SELECT count(*) FROM public."Likes" WHERE componentid = :id
            ');
            $stmt->bindParam(':id', $component['componentid'], PDO::PARAM_INT);
            $stmt->execute();
            $likes = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
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
        $stmt = $this->database->connect()->prepare('
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
                left join public."Color" using (colorid) 
                left join public."Set" using (setid) 
                left join public."Type" using (typeid)
            WHERE componentid = :id
            ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $component = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($component == false) {
            return null;
        }
        $likes = 0;
        $stmt = $this->database->connect()->prepare('
            SELECT count(*) FROM public."Likes" WHERE componentid = :id
            ');
        $stmt->bindParam(':id', $component['componentid'], PDO::PARAM_INT);
        $stmt->execute();
        $likes = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
        return new Component(
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
}