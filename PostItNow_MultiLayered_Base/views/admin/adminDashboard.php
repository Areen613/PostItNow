<?php
session_start();
if (!isset($_SESSION['admin_loggedin'])) {
    header("Location: adminLogin.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3 class="mb-4">Welcome, Admin</h3>
    <div class="mb-3">
        <a href="adminOffers.php" class="btn btn-outline-info">📩 View All Offers</a>
        <a href="adminToggleUser.php" class="btn btn-outline-warning">👥 Toggle User Status</a>
        <a href="adminDeleteAd.php" class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to delete this ad?');">🗑 Delete Ad</a>
        <a href="adminLogout.php" class="btn btn-secondary float-end">🚪 Logout</a>
    </div>
    <p>Use navigation above to manage platform content.</p>
</div>
</body>
</html>
