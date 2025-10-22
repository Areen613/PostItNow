<?php
session_start();
require_once '../../services/AdService.php';

$langCode = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'en';
$lang = include "../../lang/$langCode.php";

$service = new AdService();
$ads = $service->getAdsByMember($_SESSION['user_id']);

$offerCounts = [];
foreach ($ads as $ad) {
    $offerCounts[$ad['id']] = $service->getOfferCountByAdId($ad['id']);
}

$offerSuccess = isset($_SESSION['offer_sent']) ? $_SESSION['offer_sent'] : null;
unset($_SESSION['offer_sent']);
?>

<!DOCTYPE html>
<html lang="<?php echo $langCode; ?>">
<head>
    <meta charset="UTF-8">
    <title><?php echo isset($lang['dashboard_title']) ? $lang['dashboard_title'] : 'Dashboard'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-3 mb-4">
    <a class="navbar-brand fw-bold" href="../../index.php">PostItNow</a>
    <div class="ms-auto">
        <a href="../../handlers/LogoutHandler.php" class="btn btn-danger btn-sm">
            <?php echo isset($lang['logout']) ? $lang['logout'] : 'Logout'; ?>
        </a>
    </div>
</nav>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3><?php echo isset($lang['your_ads']) ? $lang['your_ads'] : 'Your Ads'; ?></h3>
        <a href="postAdView.php" class="btn btn-success btn-sm"><?php echo isset($lang['post_ad']) ? $lang['post_ad'] : 'Post New Ad'; ?></a>
    </div>

    <?php if (!empty($offerSuccess)): ?>
        <div class="alert alert-success"><?php echo $lang['offer_success']; ?></div>
    <?php endif; ?>

    <?php if (empty($ads)): ?>
        <div class="alert alert-info"><?php echo isset($lang['no_ads_yet']) ? $lang['no_ads_yet'] : 'You have not posted any ads yet.'; ?></div>
    <?php endif; ?>

    <div class="row">
        <?php foreach ($ads as $ad): ?>
            <div class="col-md-6">
                <div class="card mb-4 shadow-sm">
                    <?php if (!empty($ad['images'])): ?>
                        <div class="d-flex flex-wrap mb-2">
                            <?php foreach ($ad['images'] as $image): ?>
                                <img src="../../<?php echo $image; ?>" class="img-thumbnail me-2 mb-2" style="max-width: 120px;" alt="Ad Image">
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($ad['title']); ?> - $<?php echo $ad['price']; ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($ad['description']); ?></p>
                        <div class="d-flex justify-content-between">
                            <a href="editAd.php?id=<?php echo $ad['id']; ?>" class="btn btn-outline-warning btn-sm">
                                <?php echo isset($lang['edit']) ? $lang['edit'] : 'Edit'; ?>
                            </a>
                            <a href="deleteAd.php?id=<?php echo $ad['id']; ?>"
                               onclick="return confirm('<?php echo isset($lang['confirm_delete']) ? $lang['confirm_delete'] : 'Are you sure?'; ?>');"
                               class="btn btn-outline-danger btn-sm">
                                <?php echo isset($lang['delete']) ? $lang['delete'] : 'Delete'; ?>
                            </a>
                            <a href="viewOffers.php?ad_id=<?php echo $ad['id']; ?>" class="btn btn-outline-info btn-sm">
                                <?php echo isset($lang['see_offers']) ? $lang['see_offers'] : 'See Offers'; ?>
                                <?php if (!empty($offerCounts[$ad['id']])): ?>
                                    <span class="badge bg-info text-dark"><?php echo $offerCounts[$ad['id']]; ?></span>
                                <?php endif; ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>
