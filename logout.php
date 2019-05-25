<?php 

require_once(__DIR__.'/Controller/AccountController.php');

$controller = new AccountController();
$controller->logout();
$errorMessage = $controller->get_errorMessage()

?>



<!DOCTYPE html>

<html lang="ja">

<head>
<meta charset="utf-8">
<title>Log Out</title>
<link rel="stylesheet" type="text/css" href="CSS/styles_logout.css">

</head>

<body>
<div class="form-wrapper">
    <h1>Log Out</h1>
    <p><font color="blue"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES,  'SJIS'); ?></font></p>
    <ul>

        <li><a class="form-footer" href="login.php">別のアカウントでログイン</a></li>
        <li><a class="form-footer" href="index.php">ログインせずに掲示板を閲覧する</a></li>
    </ul>
</div>
</body>

</html>




