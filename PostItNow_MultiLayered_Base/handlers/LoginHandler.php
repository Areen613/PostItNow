<?php
session_start();
require_once __DIR__ . '/../services/UserService.php';


$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

if ($email == '' || $password == '') {
    $_SESSION['error'] = 'All fields are required!';
    header("Location: ../views/user/loginView.php");
    exit;
}

$service = new UserService();
$user = $service->login($email, $password);

if ($user) {
    $_SESSION['user'] = $user['email'];
    $_SESSION['user_id'] = $user['id'];
    header("Location: ../views/user/dashboard.php");
} else {
    $_SESSION['error'] = 'Invalid credentials!';
    header("Location: ../views/user/loginView.php");
}
exit;
