<?php
require_once __DIR__ . '/../db/databaseHandler.php';

class UserDAO {
    private $conn;

    public function __construct() {
        $this->conn = connect();
    }

    public function getUserByEmail($email) {
        $stmt = $this->conn->prepare("SELECT * FROM members WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function register($email, $password) {
        $stmt = $this->conn->prepare("SELECT id FROM members WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        if ($stmt->fetch()) {
            return false;
        }

        $stmt = $this->conn->prepare("INSERT INTO members (email, password) VALUES (:email, :password)");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        return $stmt->execute();
    }
}
