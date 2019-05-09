<?php

#書き込みの削除
if (isset($_POST["delete"])){

    $delete_username=$_POST["delete_username"];

    if(!isset($_SESSION["username"])){
        $errorMessage="削除にはログインが必要です。";
    }else if($_SESSION["username"] !== $delete_username){
        $errorMessage="書き込んだユーザーのみ削除をすることができます。";
    }else{
        $dsn=sprintf('mysql:dbname=%s;host=%s;charset=utf8mb4', $db['dbname'],$db['host'] );
        $pdo=new PDO($dsn, $db['user'],$db['pass'],array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
    
        $delete_id=$_POST["delete_id"];
        $sql="DELETE FROM articles WHERE id = $delete_id";
    
        if($pdo->query($sql)){
            $errorMessage="削除が完了しました。";
        }
    }
}