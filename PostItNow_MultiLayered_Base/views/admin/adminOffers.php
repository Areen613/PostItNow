<?php
session_start();
require_once '../../services/OfferService.php';

$offerService = new OfferService();
$offers = $offerService->getAllOffers();
?>

<!DOCTYPE html>
<html lang="<?php echo isset($_SESSION['lang']) ? $_SESSION['lang'] : 'en'; ?>">
<head>
    <meta charset="UTF-8">
    <title>Admin - Offers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3 class="mb-4">📨 All Offers Received</h3>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
        <tr>
            <th>Ad ID</th>
            <th>Sender ID</th>
            <th>Message</th>
            <th>Sent On</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($offers as $offer): ?>
            <tr>
                <td><?php echo $offer['ad_id']; ?></td>
                <td><?php echo $offer['sender_id']; ?></td>
                <td><?php echo htmlspecialchars($offer['message']); ?></td>
                <td><?php echo $offer['created_at']; ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
