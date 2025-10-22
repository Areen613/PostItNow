<?php
session_start();
$langCode = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'en';
$lang = include '../../lang/' . $langCode . '.php';
?>

<!DOCTYPE html>
<html lang="<?php echo $langCode; ?>">
<head>
    <meta charset="UTF-8">
    <title><?php echo isset($lang['admin_login_title']) ? $lang['admin_login_title'] : 'Admin Login'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .login-container {
            max-width: 400px;
            margin: 80px auto;
            padding: 30px;
            background: white;
            box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
    </style>
</head>
<body class="bg-light">

<div class="login-container">
    <h3 class="text-center text-primary mb-4"><?php echo $lang['admin_login_title']; ?></h3>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php elseif (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <form method="POST" action="../../handlers/AdminLoginHandler.php">
        <div class="mb-3">
            <label for="email" class="form-label"><?php echo $lang['email']; ?></label>
            <input type="email" name="email" class="form-control" required/>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label"><?php echo $lang['password']; ?></label>
            <input type="password" name="password" class="form-control" required/>
        </div>

        <button type="submit" class="btn btn-primary w-100"><?php echo $lang['login']; ?></button>
    </form>

    <div class="text-center mt-3">
        <a href="adminRegister.php"><?php echo isset($lang['no_account_register']) ? $lang['no_account_register'] : 'No account? Register'; ?></a>
    </div>
</div>

</body>
</html>
