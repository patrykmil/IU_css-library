<?php
require_once 'AppController.php';
class SecurityController extends AppController {
    public function login() {
        $this->render("login_page", ['name'=>"Patryk"]);
    }
}