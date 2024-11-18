<?php
require_once 'src/controllers/AppController.php';


$path = $_SERVER['REQUEST_URI'];

var_dump($path);

if ($path == '/component_page') {
  $controller = new AppController();
  $controller->render('component_page');
} else if ($path == '/login_page') {
  $controller = new AppController();
  $controller->render('login_page');
} else {
  $controller = new AppController();
  $controller->render('index');
}
