<?php


require_once(__DIR__.'/Controller/AccountController.php');


$controller = new AccountController();
$controller->login();
$errorMessage=$controller->get_errorMessage();

?>


<!DOCTYPE html>

<html lang="ja">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="CSS/styles_login.css">
    <title>Sign In</title>
</head>

<body>
    <div class="form-wrapper">
    <h1>Sign In</h1>
    <form id="loginForm" name="loginForm" action="" method="POST">
      
        <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
        
        <div class="form-item">
            <label for="email">E-mail</label>
            <input type="text" id="email" name="email" placeholder="メールアドレスを入力" value="<?php if (!empty($_POST["email"])){echo htmlspecialchars($_POST["email"],ENT_QUOTES);} ?>">
        </div>

        <div class="form-item">
        <label for="password">password</label>
        <input type="password" id="password" name="password" value="" placeholder="パスワードを入力">
        </div>
        <input type="hidden" name="token" value="<?=CsrfValidator::setToken()?>">
        <div class="button-panel">
        <input type="submit" id="login" class="button" name="login" value="SIGN IN">
        </div>
    </form>
    <br>

    <div class="form-footer">
        <p><a href="signup.php">Create an account</a></p>
    </div>
</body>


</html>
