<?php 
session_start();

if(isset($_SESSION["NAME"])){
    $errorMessage="ログアウトしました";
}else{
    $errorMessagee="セッションがタイムアウトしました";
}

$_SESSION=array();

@session_destroy();
?>



<!DOCTYPE html>

<html lang="ja">

<head>
<meta charset="utf-8">
<title>ログアウト</title>
</head>

<body>
    <h1>ログアウト画面</h1>
    <div><?php echo htmlspecialchars($errorMessage, ENT_QUITES); ?></div>
    <ul>
        <li><a href="login.php">ログイン画面に戻る</a></li>
    </ul>
</body>

</html>




