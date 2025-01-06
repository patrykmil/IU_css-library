<?php
session_start();
require_once 'Routing.php';
require_once 'src/controllers/AppController.php';
require_once 'DatabaseConnector.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);
Routing::run($path);

$connector = DatabaseConnector::getInstance();
