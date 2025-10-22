<?php
session_start();
require_once "services/AdService.php";

$langCode = isset($_GET['lang']) ? $_GET['lang'] : (isset($_SESSION['lang']) ? $_SESSION['lang'] : 'en');
$_SESSION['lang'] = $langCode;
$lang = include "lang/$langCode.php";

$adService = new AdService();
$flatAds = $adService->getAllActiveAds();

// Group ads by ID
$ads = array();
foreach ($flatAds as $row) {
    $adId = $row['id'];
    if (!isset($ads[$adId])) {
        $ads[$adId] = $row;
        $ads[$adId]['images'] = array();
    }
    if (!empty($row['image_path'])) {
        $ads[$adId]['images'][] = $row['image_path'];
    }
}
?>

<!DOCTYPE html>
<html lang="<?php echo $langCode; ?>">
<head>
    <meta charset="UTF-8">
    <title><?php echo $lang['homepage_title']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .brand-title {
            font-size: 28px;
            font-weight: bold;
            background: linear-gradient(to right, #0072ff, #00c6ff);
            color: white;
            padding: 6px 18px;
            border-radius: 6px;
            text-decoration: none;
        }
        .carousel-container {
            position: relative;
            overflow: hidden;
            width: 100%;
            height: 180px;
        }
        .carousel-wrapper {
            display: flex;
            overflow-x: scroll;
            scroll-behavior: smooth;
        }
        .carousel-img {
            height: 180px;
            width: auto;
            object-fit: cover;
            flex-shrink: 0;
            margin-right: 10px;
            border-radius: 6px;
        }
        .carousel-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.7);
            border: none;
            font-size: 22px;
            padding: 6px 10px;
            cursor: pointer;
            z-index: 10;
            border-radius: 50%;
        }
        .carousel-btn.left { left: 5px; }
        .carousel-btn.right { right: 5px; }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-3">
    <a class="navbar-brand brand-title" href="index.php">PostItNow</a>
    <div class="ms-auto d-flex align-items-center">
        <form method="get" class="me-3">
            <select name="lang" onchange="this.form.submit()" class="form-select form-select-sm">
                <option value="ar" <?= $langCode == 'ar' ? 'selected' : '' ?>>🇸🇦 Arabic</option>
                <option value="bn" <?= $langCode == 'bn' ? 'selected' : '' ?>>🇧🇩 বাংলা</option>
                <option value="en" <?= $langCode == 'en' ? 'selected' : '' ?>>🇬🇧 English</option>
                <option value="es" <?= $langCode == 'es' ? 'selected' : '' ?>>🇪🇸 Español</option>
                <option value="fr" <?= $langCode == 'fr' ? 'selected' : '' ?>>🇫🇷 Français</option>
                <option value="hi" <?= $langCode == 'hi' ? 'selected' : '' ?>>🇮🇳 हिन्दी</option>
                <option value="pt" <?= $langCode == 'pt' ? 'selected' : '' ?>>🇵🇹 Português</option>
                <option value="ru" <?= $langCode == 'ru' ? 'selected' : '' ?>>🇷🇺 Русский</option>
                <option value="ur" <?= $langCode == 'ur' ? 'selected' : '' ?>>🇵🇰 اردو</option>
                <option value="zh" <?= $langCode == 'zh' ? 'selected' : '' ?>>🇨🇳 中文</option>
            </select>


        </form>

        <?php if (isset($_SESSION['user'])): ?>
            <span class="me-2 text-muted"><?php echo $lang['welcome']; ?>, <?php echo htmlspecialchars($_SESSION['user']); ?></span>
            <a href="views/user/dashboard.php" class="btn btn-outline-primary btn-sm me-1"><?php echo $lang['my_dashboard']; ?></a>
            <a href="handlers/logoutHandler.php" class="btn btn-danger btn-sm"><?php echo $lang['logout']; ?></a>
        <?php elseif (isset($_SESSION['admin'])): ?>
            <a href="views/admin/adminDashboard.php" class="btn btn-outline-dark btn-sm me-1"><?php echo $lang['admin_panel']; ?></a>
            <a href="handlers/adminLogoutHandler.php" class="btn btn-danger btn-sm"><?php echo $lang['logout']; ?></a>
        <?php else: ?>
            <a href="views/user/loginView.php" class="btn btn-outline-success btn-sm me-1"><?php echo $lang['login']; ?></a>
            <a href="views/user/registerView.php" class="btn btn-success btn-sm me-1"><?php echo $lang['register']; ?></a>
            <a href="views/admin/adminLogin.php" class="btn btn-outline-secondary btn-sm me-1"><?php echo $lang['admin_login']; ?></a>
            <a href="views/admin/adminRegister.php" class="btn btn-dark btn-sm"><?php echo $lang['admin_register']; ?></a>
        <?php endif; ?>
    </div>
</nav>

<div class="container mt-4">
    <h2 class="mb-4"><?php echo $lang['homepage_heading']; ?></h2>

    <div class="row">
        <?php foreach ($ads as $ad): ?>
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="carousel-container">
                        <div class="carousel-wrapper" id="carousel-<?php echo $ad['id']; ?>">
                            <?php foreach ($ad['images'] as $img): ?>
                                <img src="/PostItNow_MultiLayered_Base/<?php echo $img; ?>" class="carousel-img" alt="Ad Image">
                            <?php endforeach; ?>
                        </div>
                        <button class="carousel-btn left" onclick="scrollCarousel('carousel-<?php echo $ad['id']; ?>', -220)">&#8249;</button>
                        <button class="carousel-btn right" onclick="scrollCarousel('carousel-<?php echo $ad['id']; ?>', 220)">&#8250;</button>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($ad['title']); ?> - $<?php echo $ad['price']; ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($ad['description']); ?></p>
                        <p class="card-text"><strong><?php echo $lang['category']; ?>:</strong> <?php echo $ad['category_name']; ?> / <?php echo $ad['subcategory_name']; ?></p>
                        <a href="views/user/adDetails.php?id=<?php echo $ad['id']; ?>" class="btn btn-primary btn-sm"><?php echo $lang['view_details']; ?></a>
                        <a href="handlers/SendOfferHandler.php?ad_id=<?php echo $ad['id']; ?>" class="btn btn-success btn-sm"><?php echo $lang['make_offer']; ?></a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    function scrollCarousel(id, offset) {
        const el = document.getElementById(id);
        if (el) el.scrollBy({ left: offset, behavior: 'smooth' });
    }
</script>

</body>
</html>
