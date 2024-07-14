<?php
// auth_controller.php
require_once 'auth_model.php';

class AuthController {
    private $authModel;

    public function __construct() {
        $this->authModel = new AuthModel();
    }

    public function login($username, $password) {
        return $this->authModel->validateUser($username, $password);
    }

    public function register($username, $password) {
        return $this->authModel->createUser($username, $password);
    }

    public function getUserRole($username) {
        return $this->authModel->getUserRole($username);
    }
}
?>