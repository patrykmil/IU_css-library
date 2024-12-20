<?php

require_once __DIR__.'/../../DatabaseConnector.php';

class Repository
{
    protected ?\DatabaseConnector $database;
    public function __construct()
    {
        $this->database = \DatabaseConnector::getInstance();
    }
}