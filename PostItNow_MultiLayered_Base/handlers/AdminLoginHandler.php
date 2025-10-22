<?php
session_start();
require_once '../../services/AdminService.php';

$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

if ($email === '' || $password === '') {
    $_SESSION['error'] = "All fields are required!";
    header("Location: ../views/admin/adminLogin.php");
    exit();
}

$adminService = new AdminService();
$admin = $adminService->login($email, $password);

if ($admin) {
    $_SESSION['admin'] = $admin['email']; // or 'name' if you store that
    $_SESSION['admin_id'] = $admin['id'];
    header("Location: ../views/admin/adminDashboard.php");
    exit();
} else {
    $_SESSION['error'] = "Invalid credentials!";
    header("Location: ../views/admin/adminLogin.php");
    exit();
}
