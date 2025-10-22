<?php
session_start();
require_once '../../services/AdService.php';

$langCode = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'en';
$lang = include "../../lang/$langCode.php";

if (!isset($_GET['id'])) {
    die("Ad ID missing.");
}

$service = new AdService();
$ad = $service->getAdById($_GET['id']);

if (!$ad || $ad['member_id'] != $_SESSION['user_id']) {
    die("Unauthorized access.");
}
?>

<!DOCTYPE html>
<html lang="<?php echo $langCode; ?>">
<head>
    <meta charset="UTF-8">
    <title><?php echo $lang['edit']; ?> - <?php echo htmlspecialchars($ad['title']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h3 class="mb-4"><?php echo $lang['edit']; ?>: <?php echo htmlspecialchars($ad['title']); ?></h3>

    <form action="../../handlers/EditAdHandler.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $ad['id']; ?>">

        <!-- rest of the fields -->


        <div class="mb-3">
            <label class="form-label"><?php echo $lang['title']; ?></label>
            <input type="text" class="form-control" name="title" value="<?php echo htmlspecialchars($ad['title']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label"><?php echo $lang['description']; ?></label>
            <textarea class="form-control" name="description" required><?php echo htmlspecialchars($ad['description']); ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label"><?php echo $lang['price']; ?></label>
            <input type="text" class="form-control" name="price" value="<?php echo $ad['price']; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label"><?php echo $lang['image']; ?> (<?php echo $lang['optional']; ?>)</label>
            <input type="file" class="form-control" name="image">
        </div>

        <button type="submit" class="btn btn-primary"><?php echo $lang['update_button']; ?></button>
        <a href="dashboard.php" class="btn btn-secondary"><?php echo $lang['cancel']; ?></a>
    </form>
</div>
</body>
</html>

