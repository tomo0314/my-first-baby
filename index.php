<?php

$dataFile="board.dat";

if($_SERVER["REQUEST_METHOD"]==="POST"){

    $message=$_POST["message"];
    $user= $_POST["user"];

    $newData= $massage . "\t" . $user . "\n";

    $fp=fopen($dataFile "a");
    fwrite($fp, $newData);
    fclose($fp);
}
?>





<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <title>僕らの掲示板</title>
</head>

<body>
    <h1>僕らの掲示版</h1>

    <section>
        <h2>新規投稿</h2>
        <form action="" method="post">
            名前：<input type="text" name="user" value=""><br>
            本文：<textarea name="message" cols="30" rows="3" maxlength="80" wrap="hard" placeholder="80文字以内で入力せよ！" ></textarea>
        </form>
    </section>

    <section>
        <h2>これまでの投稿一覧</h2>
        <p>投稿はまだありません</p>
    </section>
</body>


</html>