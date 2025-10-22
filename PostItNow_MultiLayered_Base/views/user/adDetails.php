<?php
session_start();
require_once '../../services/AdService.php';

$langCode = $_SESSION['lang'] ?? 'en';
$lang = include "../../lang/$langCode.php";

$adId = $_GET['id'] ?? null;
if (!$adId) {
    echo "<div class='alert alert-danger'>Invalid ad ID.</div>";
    exit;
}

$adService = new AdService();
$ad = $adService->getAdByIdWithImages($adId);
if (!$ad) {
    echo "<div class='alert alert-danger'>Ad not found.</div>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="<?php echo $langCode; ?>">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($ad['title']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .carousel-container {
            position: relative;
            width: 100%;
            max-width: 700px;
            height: 400px;
            margin: auto;
            overflow: hidden;
            background: #000;
            border-top-left-radius: 6px;
            border-top-right-radius: 6px;
        }

        .carousel-slide {
            display: none;
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .carousel-slide.active {
            display: block;
        }

        .carousel-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(255,255,255,0.8);
            border: none;
            font-size: 28px;
            padding: 6px 12px;
            border-radius: 50%;
            cursor: pointer;
            z-index: 2;
        }

        .carousel-btn.left {
            left: 10px;
        }

        .carousel-btn.right {
            right: 10px;
        }

        .card {
            max-width: 720px;
            margin: 40px auto;
        }
    </style>
</head>
<body class="bg-light">
<div class="container">
    <div class="card shadow">
        <div class="carousel-container">
            <?php foreach ($ad['images'] as $i => $img): ?>
                <img src="/PostItNow_MultiLayered_Base/<?php echo $img; ?>" class="carousel-slide <?php echo $i === 0 ? 'active' : ''; ?>" alt="Image <?php echo $i + 1; ?>">
            <?php endforeach; ?>

            <?php if (count($ad['images']) > 1): ?>
                <button class="carousel-btn left" onclick="scrollImage(-1)">&#10094;</button>
                <button class="carousel-btn right" onclick="scrollImage(1)">&#10095;</button>
            <?php endif; ?>
        </div>

        <div class="card-body">
            <h4 class="card-title"><?php echo htmlspecialchars($ad['title']); ?></h4>
            <p class="card-text"><?php echo htmlspecialchars($ad['description']); ?></p>
            <p><strong>Price:</strong> $<?php echo $ad['price']; ?></p>
            <p><strong>Category:</strong> <?php echo $ad['category_name'] ?: 'None'; ?> / <?php echo $ad['subcategory_name'] ?: 'None'; ?></p>
            <p><strong>Posted On:</strong> <?php echo $ad['start_date']; ?></p>
            <p><strong>Expires On:</strong> <?php echo $ad['expiry_date']; ?></p>
            <a href="../../index.php" class="btn btn-dark mt-2">🏠 Home</a>
        </div>
    </div>
</div>

<script>
    let current = 0;
    const slides = document.querySelectorAll('.carousel-slide');

    function scrollImage(direction) {
        if (slides.length === 0) return;

        slides[current].classList.remove('active');
        current = (current + direction + slides.length) % slides.length;
        slides[current].classList.add('active');
    }
</script>
</body>
</html>
