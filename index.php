<?php

session_start();

$db['host']="localhost";
$db['user']="still";
$db['pass']="Rose0314@";
$db['dbname']="bbs";

$errorMessage="";


if (isset($_POST['regist'])){

    if (empty($_POST["username"])){
        $errorMessage="ユーザー名を入力してください。";
    }else if(empty($_POST["message"])){
        $errorMessage="本文を入力してください。";
    }

    if(!empty($_POST["username"]) && !empty($_POST["messagae"])){
    
        $username= trim($_POST["username"]);
        $message=trim($_POST["message"]);
        $postedAt=date("Y-m-d:i:s");

        $dsn=sprintf('mysql:dbname=%s;host=%s;charset=utf8mb4', $db['dbname'],$db['host'] );

        try{
            $pdo=new PDO($dsn, $db['user'],$db['pass'],array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));

            #コードちゃんと理解していない
            $stmt=$pdo->prepare("INSERT INTO articles(username, message, postedAt) VALUES(:username, :message, :posteAt)");
            $stmt->binParam(':username', $username, PDO::PARAM_STR);
            $stmt->binParam(':message', $message, PDO::PARAM_STR);
            $stmt->binParam(':postedAt', $postedAt, PDO::PARAM_STR);
            $stmt->execute();
            $pdo->query($stmt);

            #INSERTしたのち、ページを更新
            header("Location: " . $_SERVER['PHP_SELF']);
            
        }catch (PDOException $e){
                $errorMessage="データベースエラー";
        } 
    }
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
        <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
            名前：<input type="text" name="username" value=""><br>
            本文：<textarea name="message" cols="30" rows="3" maxlength="80" wrap="hard" placeholder="80文字以内で入力せよ！" ></textarea>
            <input type="submit" name="regist" value="投稿">
        </form>
    </section>

    <a href="login.php">ログインはこちら</a>

    <section>
        <!-- <h2>これまでの投稿一覧(<?php echo count($stmt); ?>件)</h2> -->
            <?php
            $sql="SELECT * FROM articles ORDER BY id DESC";
            $stmt=$pdo->query($sql);
            ?>
        <ul>
            <?php foreach ($stmt as $row) : ?>
                <li><?php echo htmlspecialchars($row['username'],ENT_QUOTES|ENT_HTML5).' '.htmlspecialchars($row['message'],ENT_QUOTES|ENT_HTML5).' '.htmlspecialchars($row['postedAt'],ENT_QUOTES|ENT_HTML5);?></li>
            <br>
            <?php endforeach; ?>            
        </ul>

    </section>

    <ul>
        <li><a href="logout.php">ログアウト</a></li>
    </ul>

</body>
</html>