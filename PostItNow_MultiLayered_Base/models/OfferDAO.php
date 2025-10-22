<?php
require_once __DIR__ . '/../db/databaseHandler.php';

class OfferDAO {
    private $conn;

    public function __construct() {
        $this->conn = connect();
    }

    public function createOffer($adId, $senderId, $message) {
        $sql = "INSERT INTO offers (ad_id, sender_id, message, created_at)
                VALUES (:ad_id, :sender_id, :message, NOW())";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':ad_id', $adId, PDO::PARAM_INT);
        $stmt->bindParam(':sender_id', $senderId, PDO::PARAM_INT);
        $stmt->bindParam(':message', $message);
        return $stmt->execute();
    }

    public function getOffersByAdId($adId) {
        $stmt = $this->conn->prepare("
            SELECT o.*, m.name AS sender_name
            FROM offers o
            JOIN members m ON o.sender_id = m.id
            WHERE o.ad_id = :ad_id
            ORDER BY o.created_at DESC
        ");
        $stmt->bindParam(':ad_id', $adId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOffersByMember($memberId) {
        $sql = "SELECT offers.*, ads.title AS ad_title
                FROM offers
                JOIN ads ON offers.ad_id = ads.id
                WHERE offers.sender_id = :member_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':member_id', $memberId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function saveReply($offerId, $reply) {
        $sql = "UPDATE offers SET reply = :reply WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':reply', $reply);
        $stmt->bindParam(':id', $offerId);
        return $stmt->execute();
    }

    public function getAllOffers() {
        $sql = "SELECT offers.*, members.name AS sender_name, ads.title AS ad_title
                FROM offers
                JOIN members ON offers.sender_id = members.id
                JOIN ads ON offers.ad_id = ads.id
                ORDER BY offers.created_at DESC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
