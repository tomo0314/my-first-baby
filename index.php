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

if (isset($_POST["delete"])){
    $dsn=sprintf('mysql:dbname=%s;host=%s;charset=utf8mb4', $db['dbname'],$db['host'] );
    $pdo=new PDO($dsn, $db['user'],$db['pass'],array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));

    $delete_id=$_POST["delete_id"];
    $sql="DELETE FROM articles WHERE id = $delete_id";

    if($pdo->query($sql)){
        $errorMessage="削除が完了しました。";
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
    <h1>進路と受験の悩みについて語ろうや！</h1>

    <section>
        <h2>新規投稿</h2>
        <form action="" method="post">
        <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
            名前：<?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES); ?><br>
            本文：<textarea name="message" cols="30" rows="3" maxlength="80" wrap="hard" placeholder="80文字以内で入力してください。" ></textarea>
            <input type="submit" name="regist" value="投稿">
        </form>
    </section>

    <ul>
        <li><a href="login.php">ログインはこちら</a></li>

        <li><a href="logout.php">ログアウト</a></li>
    </ul>

    <section>
        <h2>これまでの投稿一覧</h2> 
            <?php
            $dsn=sprintf('mysql:dbname=%s;host=%s;charset=utf8mb4', $db['dbname'],$db['host'] );
            $pdo=new PDO($dsn, $db['user'],$db['pass'],array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));

            $sql="SELECT * FROM articles ORDER BY id DESC";
            $stmt=$pdo->query($sql);
            ?>

        
        <ul>
            <?php while($articles= $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
                <li><tr>
                    <td><?php echo h($articles['username']);?></td>
                    <td><?php echo h($articles['message']);?></td>
                    <td><?php echo h($articles['postedAt']);?></td>
                    <form action="" method="post">
						<input type="hidden" name="delete_id" value=<?php echo $articles['id']; ?>>
						<button class="btn btn-danger" name="delete" type="submit">削除</button>
					</form>
                <br>
                
                </tr>
                </li>    
            
            <?php endwhile; ?>       
        </ul>

    </section>

</body>
</html>