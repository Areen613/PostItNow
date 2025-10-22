<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "Please log in to post an ad.";
    header("Location: ../views/user/loginView.php");
    exit();
}

require_once '../services/AdService.php';

$data = [
    'member_id' => $_SESSION['user_id'], // important!
    'title' => $_POST['title'],
    'description' => $_POST['description'],
    'price' => $_POST['price'],
    'category_id' => $_POST['category_id'],
    'subcategory_id' => $_POST['subcategory_id'],
    'start_date' => date('Y-m-d'),
    'expiry_date' => $_POST['expiry_date'],
    'status' => 'active'
];

$adService = new AdService();
$adId = $adService->createAd($data);

if ($adId) {
    // handle image upload if needed...
    $_SESSION['success'] = "Ad posted successfully!";
    header("Location: ../views/user/dashboard.php");
    exit();
} else {
    $_SESSION['error'] = "Failed to post the ad.";
    header("Location: ../views/user/postAdView.php");
    exit();
}
