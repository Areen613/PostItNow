<?php
require_once '../services/CategoryService.php';

if (isset($_POST['category_id'])) {
    $service = new CategoryService();
    $subcats = $service->getSubcategoriesByCategoryId($_POST['category_id']);

    foreach ($subcats as $sub) {
        echo '<option value="' . $sub['id'] . '">' . htmlspecialchars($sub['name']) . '</option>';
    }
}
?>

