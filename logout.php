<?php 
session_start();

$errorMessage="";

if(isset($_SESSION["username"])){
    $errorMessage="ログアウトしました";
}else{
    $errorMessage="セッションがタイムアウトしました";
}

#セッション変数（ユーザーの情報）を空の配列によって初期化する
$_SESSION=array();

#cookie（ブラウザ）上のユーザーデータも削除
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-42000, '/');
}

#ユーザーのサーバーからのセッションの削除
session_destroy();
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




