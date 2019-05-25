<?php

require_once(__DIR__.'/Controller/IndexController.php');

$controller = new IndexController();
$controller->execute();
$errorMessage = $controller->getErrorMessage();
$articles = $controller->getArticles();
  
function h($s){
    echo htmlspecialchars($s,ENT_QUOTES|ENT_HTML5);
}
?>
 

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <title>philosophy</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
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
            <div class="name">名前</div>
            <?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES); ?><br>
            <div class="message">メッセージ</div><br>
            <textarea name="message" cols="30" rows="3" maxlength="140" wrap="hard" ></textarea><br>
            <input type="hidden" name="token_post" value="<?=CsrfValidator::setToken()?>">       
            <input class="button" type="submit" name="regist" value="投稿">
        </form>
    </section>

    <ul>
        <li><a href="login.php">ログイン</a></li>
        <li><a href="logout.php">ログアウト</a></li>
    </ul>
                                                    
    <section class="Posts">
        <h2>Posts</h2> 

        <ul>
            <?php foreach($articles as $article) : ?>
      
                <div class="user_box_front">
                <li><tr>
                    <div class="comment">
                    <td><i class="fas fa-user-circle"></i></td>
                    <td><div class="bold"><?php echo h($article['username'])?></div></td>
                    <td><div class="small"><?php echo h($article['postedAt']);?></div></td>
                    <td><div class="small2"><?php echo h($article['message']);?></div></td>
                    </div>
                    <td>
                    <form action="" method="post">
						<input type="hidden" name='delete_id' value=<?php echo $article['id']; ?>>
                        <input type="hidden" name='delete_username' value=<?php echo $article['username']; ?>>
                        <input type="hidden" name="token_delete" value="<?=CsrfValidator::setToken()?>">       
						<button name="delete" type="submit">削除</button>
					</form>
                    </td>
                </tr> </li>    
                </div>
            
            <?php endforeach; ?>       
        </ul>

    </section>
    </div>

    <footer>
        <section class="sns">
            <a href="https://twitter.com"><i class="fab fa-twitter"></i></a>
            <a href="https://www.facebook.com"><i class="fab fa-facebook-f"></i></a>
            <a href="https://www.messenger.com"><i class="fab fa-facebook-messenger"></i></a>
            <a href="https://social-plugins.line.me/lineit/share?url={encodeURIComponent(http://192.168.33.10:8000/index.php###)}"><i class="fab fa-line"></i></a>
        </section>

        <p>Copyright (C) 2019 Philosophy -life,work and love-  All Rights Reserved.</p>
    </footer>
</body>
</html>