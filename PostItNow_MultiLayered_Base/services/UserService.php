<?php
require_once __DIR__ . '/../models/UserDAO.php';

class UserService {
    private $userDAO;

    public function __construct() {
        $this->userDAO = new UserDAO();
    }

    public function login($email, $password) {
        $user = $this->userDAO->getUserByEmail($email);
        if ($user && $user['password'] === $password) {
            return $user;
        }
        return false;
    }

    public function register($email, $password) {
        return $this->userDAO->register($email, $password);
    }
}
