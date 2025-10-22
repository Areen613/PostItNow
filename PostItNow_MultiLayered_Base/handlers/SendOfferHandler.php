<?php
session_start();
require_once '../services/OfferService.php';
require_once '../services/AdService.php';

// Validate session
if (!isset($_SESSION['user_id'])) {
    header("Location: ../views/user/loginView.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $adId = isset($_POST['ad_id']) ? $_POST['ad_id'] : null;
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';
    $senderId = $_SESSION['user_id'];

    if ($adId && $message !== '') {
        $offerService = new OfferService();
        $adService = new AdService();

        // Get seller email to notify
        $sellerEmail = $adService->getSellerEmailByAdId($adId);

        if ($sellerEmail) {
            $success = $offerService->sendOffer($adId, $senderId, $message);

            if ($success) {
                // You could add mail() logic here to send notification to seller
                $_SESSION['offer_sent'] = "Your offer was successfully sent.";
            } else {
                $_SESSION['offer_sent'] = "Failed to send offer.";
            }
        } else {
            $_SESSION['offer_sent'] = "Seller not found for the selected ad.";
        }
    } else {
        $_SESSION['offer_sent'] = "All fields are required.";
    }

    header("Location: ../index.php");
    exit;
}
?>
