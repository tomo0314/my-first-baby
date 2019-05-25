<?php

require_once(__DIR__.'/Controller/AccountController.php');

$controller = new AccountController();
$controller->signup();
$errorMessage = $controller->get_errorMessage();
$signupMessage = $controller->get_signupMessage();

?>


<!DOCTYPE html>

<html lang="ja">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="CSS/styles_signup.css">
    <title>Sign Up</title>
</head>

<body>
    <div class="form-wrapper">
    <h1>Sign Up</h1>
    <form id="loginForm" name="loginForm" action="" method="POST">
        <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
        <div><font color="#0000ff"><?php echo htmlspecialchars($signupMessage,ENT_QUOTES); ?></font></div>
        <div class="form-item">   
            <label for="username">Name</label>
            <input type="text" id="username" name="username" placeholder="ユーザー名を入力" value="<?php if (!empty($_POST["username"])){echo htmlspecialchars($_POST["username"],ENT_QUOTES);} ?>">
            <br>
        </div>
        <div class="form-item">
            <label for="email">E-mail</label>
            <input type="text" id="email" name="email" placeholder="メールアドレスを入力" value="<?php if (!empty($_POST["email"])){echo htmlspecialchars($_POST["email"],ENT_QUOTES);} ?>">
            <br>
        </div>
        <div class="form-item">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" value="" placeholder="パスワードを入力">
            <br>
        </div>
        <div class="form-item">
            <label for="password2">Password(again)</label>
            <input type="password" id="password2" name="password2" value="" placeholder="再度パスワードを入力">
            <br>
        </div>
        <div class="button-panel">
            <input type="submit" id="signUp" class="button" name="signUp" value="Sign Up">
        </div>
    </form>

    <br>
    <div class="form-footer">
        <p><a href="login.php">Sign In</p>
    </div>

</div>
</body>

</html>




