<?php
session_start();
require_once '../../services/OfferService.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index.php");
    exit;
}

if (!isset($_GET['ad_id']) || !is_numeric($_GET['ad_id'])) {
    echo "<div class='alert alert-danger'>Invalid Ad ID passed: " . htmlspecialchars($_GET['ad_id'] ?? 'NULL') . "</div>";
    exit;
}


$adId = $_GET['ad_id'];
$offerService = new OfferService();
$offers = $offerService->getOffersByAdId($adId);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Offers for Ad</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h3 class="mb-4">Offers Received</h3>

    <?php if (empty($offers)): ?>
        <div class="alert alert-info">No offers yet for this ad.</div>
    <?php else: ?>
        <ul class="list-group">
            <?php foreach ($offers as $offer): ?>
                <li class="list-group-item">
                    <strong>From:</strong> <?php echo htmlspecialchars($offer['sender_name']); ?><br>
                    <strong>Message:</strong> <?php echo htmlspecialchars($offer['message']); ?><br>
                    <strong>Date:</strong> <?php echo $offer['created_at']; ?><br>

                    <?php if (!empty($offer['reply'])): ?>
                        <strong>Reply:</strong> <?php echo htmlspecialchars($offer['reply']); ?>
                    <?php else: ?>
                        <!-- Reply Form -->
                        <form action="../../handlers/ReplyToOfferHandler.php" method="post" class="mt-2">
                            <input type="hidden" name="offer_id" value="<?php echo $offer['id']; ?>">
                            <div class="mb-2">
                                <textarea name="reply" class="form-control" placeholder="Type your reply..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary">Reply</button>
                        </form>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <a href="dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
</div>
</body>
</html>
