<?php
require_once 'src/repositories/ComponentRepository.php';
require_once 'src/models/Component.php';
require_once 'src/models/User.php';
require_once 'src/models/Tag.php';

$repository = ComponentRepository::getInstance();
$components = $repository->getComponentById(1);
echo $components->getEveythingJSON();
?>