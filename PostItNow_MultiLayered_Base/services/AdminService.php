<?php
require_once __DIR__ . '/../models/AdminDAO.php';

class AdminService {
    private $dao;

    public function __construct() {
        $this->dao = new AdminDAO();
    }

    public function register($email, $password) {
        return $this->dao->register($email, $password);
    }

    public function login($email, $password) {
        return $this->dao->login($email, $password);
    }
}
