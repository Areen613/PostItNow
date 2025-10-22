<?php
require_once __DIR__ . '/../db/databaseHandler.php';

class AdDAO {
    private $conn;
    public function getSellerEmailByAdId($adId) {
        $sql = "SELECT m.email
            FROM ads a
            JOIN members m ON a.member_id = m.id
            WHERE a.id = :ad_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':ad_id', $adId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function __construct() {
        $this->conn = connect();
    }

    public function createAd($data) {
        $sql = "INSERT INTO ads (member_id, title, description, price, category_id, subcategory_id, start_date, expiry_date, status)
                VALUES (:member_id, :title, :description, :price, :category_id, :subcategory_id, :start_date, :expiry_date, :status)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':member_id', $data['member_id']);
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':category_id', $data['category_id']);
        $stmt->bindParam(':subcategory_id', $data['subcategory_id']);
        $stmt->bindParam(':start_date', $data['start_date']);
        $stmt->bindParam(':expiry_date', $data['expiry_date']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    public function saveAdImage($adId, $imagePath) {
        $sql = "INSERT INTO ad_images (ad_id, image_path) VALUES (:ad_id, :image_path)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':ad_id', $adId);
        $stmt->bindParam(':image_path', $imagePath);
        $stmt->execute();
    }


    public function getAllActiveAds() {
        $sql = "SELECT ads.*, categories.category_name AS category_name, subcategories.subcategory_name AS subcategory_name, ad_images.image_path
                FROM ads
                LEFT JOIN categories ON ads.category_id = categories.id
                LEFT JOIN subcategories ON ads.subcategory_id = subcategories.id
                LEFT JOIN ad_images ON ads.id = ad_images.ad_id
                WHERE ads.status = 'active'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAdByIdWithImages($adId) {
        $stmt = $this->conn->prepare("
        SELECT 
            ads.*, 
            categories.category_name, 
            subcategories.subcategory_name, 
            ad_images.image_path 
        FROM ads
        LEFT JOIN categories ON ads.category_id = categories.id
        LEFT JOIN subcategories ON ads.subcategory_id = subcategories.id
        LEFT JOIN ad_images ON ads.id = ad_images.ad_id
        WHERE ads.id = ?
    ");
        $stmt->execute([$adId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($rows)) return null;

        $ad = $rows[0];
        $ad['images'] = [];

        foreach ($rows as $row) {
            if (!empty($row['image_path'])) {
                $ad['images'][] = $row['image_path'];
            }
        }

        return $ad;
    }
    public function getOfferCountByAdId($adId) {
        $sql = "SELECT COUNT(*) FROM offers WHERE ad_id = :ad_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':ad_id', $adId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn();
    }


    public function getAdsByMember($memberId) {
        $sql = "SELECT ads.*, categories.category_name AS category_name, subcategories.subcategory_name AS subcategory_name
            FROM ads
            LEFT JOIN categories ON ads.category_id = categories.id
            LEFT JOIN subcategories ON ads.subcategory_id = subcategories.id
            WHERE ads.member_id = :member_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':member_id', $memberId, PDO::PARAM_INT);
        $stmt->execute();
        $ads = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Add associated images
        foreach ($ads as &$ad) {
            $imageStmt = $this->conn->prepare("SELECT image_path FROM ad_images WHERE ad_id = :ad_id");
            $imageStmt->bindParam(':ad_id', $ad['id'], PDO::PARAM_INT);
            $imageStmt->execute();
            $images = $imageStmt->fetchAll(PDO::FETCH_COLUMN);
            $ad['images'] = $images;
        }

        return $ads;
    }

    public function updateAd($id, $title, $desc, $price, $imagePath = null) {
        // Ensure ID is valid
        if (!$id) return;

        // Update core ad details
        $sql = "UPDATE ads SET title = :title, description = :desc, price = :price WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':desc', $desc);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // If image path is provided, update the ad_images table
        if (!empty($imagePath)) {
            // Remove old image if any
            $deleteStmt = $this->conn->prepare("DELETE FROM ad_images WHERE ad_id = :ad_id");
            $deleteStmt->bindParam(':ad_id', $id, PDO::PARAM_INT);
            $deleteStmt->execute();

            // Insert new image
            $insertStmt = $this->conn->prepare("INSERT INTO ad_images (ad_id, image_path) VALUES (:ad_id, :image_path)");
            $insertStmt->bindParam(':ad_id', $id, PDO::PARAM_INT);
            $insertStmt->bindParam(':image_path', $imagePath);
            $insertStmt->execute();
        }
    }

    public function getImagesByAdId($adId) {
        $sql = "SELECT * FROM ad_images WHERE ad_id = :ad_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':ad_id', $adId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    public function getAdById($id) {
        $sql = "SELECT ads.*, categories.category_name AS category_name, subcategories.subcategory_name AS subcategory_name, ad_images.image_path
                FROM ads
                LEFT JOIN categories ON ads.category_id = categories.id
                LEFT JOIN subcategories ON ads.subcategory_id = subcategories.id
                LEFT JOIN ad_images ON ads.id = ad_images.ad_id
                WHERE ads.id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
