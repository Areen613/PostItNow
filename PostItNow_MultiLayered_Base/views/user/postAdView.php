<?php
session_start();
$langCode = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'en';
$lang = include "../../lang/$langCode.php";
require_once '../../services/CategoryService.php';
$catService = new CategoryService();
$categories = $catService->getAllCategories();
?>

<!DOCTYPE html>
<html lang="<?php echo $langCode; ?>">
<head>
    <meta charset="UTF-8">
    <title><?php echo isset($lang['post_ad_title']) ? $lang['post_ad_title'] : 'Post Ad'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-3 mb-4">
    <a class="navbar-brand fw-bold" href="../../index.php">PostItNow</a>
    <div class="ms-auto">
        <a href="dashboard.php" class="btn btn-outline-primary btn-sm"><?php echo $lang['dashboard']; ?></a>
        <a href="../../handlers/LogoutHandler.php" class="btn btn-danger btn-sm ms-2"><?php echo $lang['logout']; ?></a>
    </div>
</nav>

<div class="container">
    <h3 class="mb-4"><?php echo $lang['post_ad_heading']; ?></h3>

    <form action="../../handlers/PostAdHandler.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label"><?php echo $lang['title']; ?></label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label"><?php echo $lang['description']; ?></label>
            <textarea name="description" class="form-control" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label"><?php echo $lang['price']; ?></label>
            <input type="text" name="price" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label"><?php echo $lang['category']; ?></label>
            <select name="category_id" id="category" class="form-select" required>
                <option value=""><?php echo $lang['select_category']; ?></option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['category_name']); ?></option>
                <?php endforeach; ?>
            </select>

        </div>

        <div class="mb-3">
            <label class="form-label"><?php echo $lang['subcategory']; ?></label>
            <select name="subcategory_id" id="subcategory" class="form-select">
                <option value=""><?php echo $lang['select_subcategory']; ?></option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label"><?php echo $lang['image']; ?> (You can upload multiple)</label>
            <input type="file" name="images[]" class="form-control" multiple required>
        </div>


        <button type="submit" class="btn btn-success"><?php echo $lang['submit_ad']; ?></button>
        <a href="dashboard.php" class="btn btn-secondary"><?php echo $lang['cancel']; ?></a>
    </form>
</div>

<!-- Plain JavaScript AJAX -->
<script>
    document.getElementById('category').addEventListener('change', function () {
        var categoryId = this.value;
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../../handlers/fetchSubcategories.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                document.getElementById('subcategory').innerHTML = '<option value=""><?php echo $lang['select_subcategory']; ?></option>' + xhr.responseText;
            }
        };
        xhr.send('category_id=' + encodeURIComponent(categoryId));
    });
</script>

</body>
</html>
