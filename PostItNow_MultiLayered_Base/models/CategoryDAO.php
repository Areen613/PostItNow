<?php
require_once __DIR__ . '/../db/databaseHandler.php';

class CategoryDAO
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = connect();
    }

    public function getAll()
    {
        $sql = "SELECT id, category_name FROM categories";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSubcategories($categoryId)
    {
        $sql = "SELECT id, name FROM subcategories WHERE category_id = :category_id ORDER BY name ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

