<?php
require_once __DIR__ . '/../models/OfferDAO.php';

class OfferService {
    private $dao;

    public function __construct() {
        $this->dao = new OfferDAO();
    }
    public function getOffersByAdId($adId) {
        return $this->dao->getOffersByAdId($adId);
    }


    public function sendOffer($adId, $senderId, $message) {
        return $this->dao->createOffer($adId, $senderId, $message);
    }

    public function getOffersByAd($adId) {
        return $this->dao->getOffersByAd($adId);
    }

    public function getOffersByMember($memberId) {
        return $this->dao->getOffersByMember($memberId);
    }

    public function getAllOffers() {
        return $this->dao->getAllOffers();
    }
}
?>
