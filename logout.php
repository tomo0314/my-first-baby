<?php 
session_start();

if(isset($_SESSION["NAME"])){
    $errorMessage="ログアウトしました";
}else{
    $errorMessagee="セッションがタイムアウトしました";
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




