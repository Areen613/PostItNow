<?php
session_start();
require_once '../models/OfferDAO.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $offerId = $_POST['offer_id'];
    $reply = trim($_POST['reply']);

    if (!empty($offerId) && !empty($reply)) {
        $dao = new OfferDAO();
        $dao->saveReply($offerId, $reply);
        $_SESSION['success'] = "Reply sent successfully!";
    } else {
        $_SESSION['error'] = "Reply cannot be empty.";
    }
}

header("Location: ../views/user/viewOffers.php");
exit();

