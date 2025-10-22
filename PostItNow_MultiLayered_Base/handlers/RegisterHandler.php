<?php
session_start();
require_once __DIR__ . '/../services/UserService.php';

$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

if ($name === '' || $email === '' || $password === '') {
    $_SESSION['error'] = 'All fields are required!';
    header("Location: ../views/user/registerView.php");
    exit();
}

$service = new UserService();
$registered = $service->register($name, $email, $password);

if ($registered) {
    $_SESSION['success'] = 'Registration successful! You can now log in.';
    header("Location: ../views/user/loginView.php");
    exit();
} else {
    $_SESSION['error'] = 'Email already exists.';
    header("Location: ../views/user/registerView.php");
    exit();
}
