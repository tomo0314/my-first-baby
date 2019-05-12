<?php

session_start();

function h($s){
    echo htmlspecialchars($s,ENT_QUOTES|ENT_HTML5);
}

$db['host']="localhost";
$db['user']="still";
$db['pass']="Rose0314@";
$db['dbname']="bbs";

$errorMessage="";


if (isset($_POST['regist'])){

    if (empty($_POST["message"])){
        $errorMessage="本文を入力してください。";
    }

    #書き込みのデータベース登録
    if(!empty($_SESSION["username"]) && !empty($_POST["message"])){
        
        #ユーザー名・本文・投稿時間の取得
        $username= ($_SESSION["username"]);
        $message=($_POST["message"]);

        date_default_timezone_set('Asia/Tokyo');
        $postedAt=date("Y-m-d:i:s");

        $dsn=sprintf('mysql:dbname=%s;host=%s;charset=utf8mb4', $db['dbname'],$db['host'] );

        #データベースへの挿入
        try{
            $pdo=new PDO($dsn, $db['user'],$db['pass'],array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));

            #INSERTとFETCH
            $stmt=$pdo->prepare("INSERT INTO articles(username, message, postedAt) VALUES(?,?,?)");
            $stmt->execute(array($username, $message, $postedAt));
            
            
            #INSERT後、ページを更新
            header("Location: " . $_SERVER['PHP_SELF']);
            
        }catch (PDOException $e){
                $errorMessage="データベースエラー";
        } 
    }else{
        $errorMessage="書き込みをするためには、ログインが必要です。";
    }
}

#削除
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
        
    
?>
 

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <title>philosophy</title>
    <link rel="stylesheet" type="text/css" href="CSS/styles_index.css">
</head>

<body>
    <div class="header">
    <img src="/CSS/photos/header.jpg" alt=header_photo class="header_img"> 
    <h1>Philosophy -life,work and love-</h1>
    </div>

    <div class="contaigner">
    <section>
        <h2>New Post</h2>
        <form action="" method="post">
        <div class="form"><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
            <div class="name">名前<br>
            <?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES); ?></div><br>
            <div class="message">メッセージ<br>
            <textarea name="message" cols="30" rows="3" maxlength="80" wrap="hard" placeholder="80文字以内で入力してください。" ></textarea></div>
            <input class="button" type="submit" name="regist" value="投稿">
        </form>
    </section>

    <ul>
        <li><a href="login.php">ログイン</a></li>

        <li><a href="logout.php">ログアウト</a></li>
    </ul>
        
    <section class="Posts">
        <h2>Posts</h2> 
            <?php
            $dsn=sprintf('mysql:dbname=%s;host=%s;charset=utf8mb4', $db['dbname'],$db['host'] );
            $pdo=new PDO($dsn, $db['user'],$db['pass'],array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));

            $sql="SELECT * FROM articles ORDER BY id DESC";
            $stmt=$pdo->query($sql);
            ?>

        
        <ul>
            <?php while($articles= $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
      
                <div class="user_box_front">
                <li><tr>
                    <div class="body">
                    <td> <div class="icon size40" style="background-image: url('https://menta.work/resource/img/noimage.png');"></div></td>
                    <td><div class="bold"><?php echo h($articles['username'])?></div></td>
                    <td><div class="small"><?php echo h($articles['postedAt']);?></div></td>
                    <td><div class="small2"><?php echo h($articles['message']);?></div></td>
                    </div>
                    <td>
                    <form action="" method="post">
						<input type="hidden" name="delete_id" value=<?php echo $articles['id']; ?>>
                        <input type="hidden" name="delete_username" value=<?php echo $articles['username']; ?>>
						<button class="button" name="delete" type="submit">削除</button>
					</form>
                    </td>
                </tr>
                </li>    
                </div>
            
            <?php endwhile; ?>       
        </ul>

    </section>
    </div>
</body>
</html>