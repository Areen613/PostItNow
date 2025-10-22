<?php
require_once __DIR__ . '/../models/CategoryDAO.php';

class CategoryService
{
    private $dao;

    public function __construct()
    {
        $this->dao = new CategoryDAO();
    }

    public function getAllCategories()
    {
        return $this->dao->getAll();
    }

    public function getSubcategoriesByCategoryId($categoryId)
    {
        return $this->dao->getSubcategories($categoryId);
    }
}
?>

