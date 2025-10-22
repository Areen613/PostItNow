<?php
session_start();

$langCode = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'en';
$langFile = "../../lang/" . $langCode . ".php";
if (file_exists($langFile)) {
    $lang = include $langFile;
} else {
    $lang = include "../../lang/en.php";
}
?>

<!DOCTYPE html>
<html lang="<?php echo $langCode; ?>">
<head>
    <meta charset="UTF-8">
    <title><?php echo isset($lang['admin_register_title']) ? $lang['admin_register_title'] : 'Admin Registration'; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .register-box {
            max-width: 400px;
            margin: 80px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .form-label {
            font-weight: bold;
        }
    </style>
</head>
<body class="bg-light">

<div class="register-box">
    <h3 class="text-center mb-4 text-primary">
        <?php echo isset($lang['admin_register_title']) ? $lang['admin_register_title'] : 'Admin Registration'; ?>
    </h3>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php elseif (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <form action="../../handlers/AdminRegisterHandler.php" method="post">
        <div class="mb-3">
            <label for="email" class="form-label"><?php echo isset($lang['email']) ? $lang['email'] : 'Email'; ?></label>
            <input type="email" class="form-control" id="email" name="email" required />
        </div>
        <div class="mb-3">
            <label for="password" class="form-label"><?php echo isset($lang['password']) ? $lang['password'] : 'Password'; ?></label>
            <input type="password" class="form-control" id="password" name="password" required />
        </div>
        <button type="submit" class="btn btn-primary w-100">
            <?php echo isset($lang['register']) ? $lang['register'] : 'Register'; ?>
        </button>
    </form>

    <div class="text-center mt-3">
        <a href="adminLogin.php"><?php echo isset($lang['already_have_account']) ? $lang['already_have_account'] : 'Already have an account? Login'; ?></a>
    </div>
</div>

</body>
</html>
