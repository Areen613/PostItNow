<?php
session_start();
require_once __DIR__ . '/../services/AdminService.php';


$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

if ($email === '' || $password === '') {
    $_SESSION['error'] = 'All fields are required!';
    header("Location: ../views/admin/adminRegister.php");
    exit();
}

$adminService = new AdminService();
$result = $adminService->register($email, $password);

if ($result === true) {
    $_SESSION['success'] = 'Admin registered successfully!';
    header("Location: ../views/admin/adminLogin.php");
    exit();
} else {
    $_SESSION['error'] = 'Registration failed. Email might already be in use.';
    header("Location: ../views/admin/adminRegister.php");
    exit();
}
