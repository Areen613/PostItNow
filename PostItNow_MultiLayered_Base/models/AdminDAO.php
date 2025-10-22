<?php
require_once __DIR__ . '/../db/databaseHandler.php';

class AdminDAO {
    private $conn;

    public function __construct() {
        $this->conn = connect();
    }

    public function register($email, $password) {
        // Check if admin email already exists
        $stmt = $this->conn->prepare("SELECT id FROM admins WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->fetch()) {
            return false; // Email already exists
        }

        // Hash password (PHP 5.6-compatible)
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $this->conn->prepare("INSERT INTO admins (email, password) VALUES (:email, :password)");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);

        return $stmt->execute();
    }

    public function login($email, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM admins WHERE email = :email LIMIT 1");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && password_verify($password, $admin['password'])) {
            return $admin;
        }

        return false;
    }
}
