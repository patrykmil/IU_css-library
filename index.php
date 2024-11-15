<?php
require_once 'src/controllers/AppController.php';


$path = $_SERVER['REQUEST_URI'];

var_dump($path);

if ($path == '/index') {
  $controller = new AppController();
  $controller->render('index');
} else {
  $controller = new AppController();
  $controller->render('index');
}
