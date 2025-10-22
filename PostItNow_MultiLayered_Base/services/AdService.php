<?php
require_once __DIR__ . '/../models/AdDAO.php';


class AdService {
    private $dao;

    public function __construct() {
        $this->dao = new AdDAO();
    }
    public function getOfferCountByAdId($adId) {
        require_once __DIR__ . '/../models/AdDAO.php';
        $dao = new AdDAO();
        return $dao->getOfferCountByAdId($adId);
    }

    public function updateAd($id, $title, $desc, $price, $imagePath = null) {
        $this->dao->updateAd($id, $title, $desc, $price, $imagePath);
    }
    public function getSellerEmailByAdId($adId) {
        return $this->dao->getSellerEmailByAdId($adId);
    }
    public function getAdByIdWithImages($adId) {
        return $this->dao->getAdByIdWithImages($adId);
    }

    public function getAdsByMember($memberId) {
        return $this->dao->getAdsByMember($memberId);
    }

    public function postAd($memberId, $title, $desc, $price, $imagePath, $categoryId, $subcategoryId) {
        $adData = array(
            'member_id' => $memberId,
            'title' => $title,
            'description' => $desc,
            'price' => $price,
            'category_id' => $categoryId,
            'subcategory_id' => $subcategoryId,
            'start_date' => date('Y-m-d'),
            'expiry_date' => date('Y-m-d', strtotime('+30 days')),
            'status' => 'active'
        );

        $adId = $this->dao->createAd($adData);
        if ($adId && $imagePath) {
            $this->dao->saveAdImage($adId, $imagePath);
        }

        return $adId;
    }

    public function getAdById($id) {
        return $this->dao->getAdById($id);
    }

    public function getAllActiveAds() {
        return $this->dao->getAllActiveAds();
    }
}
