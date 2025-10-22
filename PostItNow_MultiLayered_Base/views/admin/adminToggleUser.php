<?php
session_start();
require_once '../../services/UserService.php';

$lang = include "../../lang/" . (isset($_SESSION['lang']) ? $_SESSION['lang'] : 'en') . ".php";

$userService = new UserService();
$users = $userService->getAllUsers();
?>

<!DOCTYPE html>
<html lang="<?php echo isset($_SESSION['lang']) ? $_SESSION['lang'] : 'en'; ?>">
<head>
    <meta charset="UTF-8">
    <title><?php echo $lang['toggle_user_title']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3><?php echo $lang['toggle_user_heading']; ?></h3>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th><?php echo $lang['name']; ?></th>
            <th><?php echo $lang['email']; ?></th>
            <th><?php echo $lang['status']; ?></th>
            <th><?php echo $lang['action']; ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo $user['id']; ?></td>
                <td><?php echo htmlspecialchars($user['name']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td>
                    <?php echo $user['status'] == 'active' ? $lang['active'] : $lang['inactive']; ?>
                </td>
                <td>
                    <form action="../../handlers/ToggleUserHandler.php" method="POST" style="display:inline;">
                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                        <button type="submit" class="btn btn-warning btn-sm">
                            <?php echo $lang['toggle']; ?>
                        </button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
