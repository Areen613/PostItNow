<?php
session_start();
require_once '../../services/AdService.php';

if (!isset($_GET['id'])) {
    die("Missing ad ID");
}

$service = new AdService();
$ad = $service->getAdById($_GET['id']);

if ($ad['member_id'] != $_SESSION['user_id']) {
    die("Unauthorized");
}

$service->deleteAd($_GET['id']);
header("Location: dashboard.php");
exit();

