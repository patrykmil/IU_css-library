<?php
require_once 'AppController.php';
class ComponentController extends AppController {
    public function component() {
        $this->render("component_page");
    }
}