<?php

$dataFile="bbs.dat";

/*
//CSRF対策

session_start();

function setToken(){
    $token=sha1(uniqid(mt_rand(),true));
    $_SESSION["token"]=$token;
}

function checkToken(){
    if(empty($_SESSION["token"]) || ($_SESSION["token"]!= $_POST["token"])){
        echo "不正なPOSTが行われました";
        exit;
    }
}

*/

function h($s){
    return htmlspecialchars($s,ENT_QUOTES,"utf-8");
}

if ($_SERVER["REQUEST_METHOD"]==="POST" &&
isset($_POST["user"]) && 
isset($_POST["message"])){

    // checkToken();

    $user= trim($_POST["user"]);
    $message=trim($_POST["message"]);

    if ($message !== ''){
       
        if($user ===""){
            $user="名無しさん";
        }else{
            $user=$user;
        }
        $user= str_replace("\t", ' ',$user);
        $message= str_replace("\t", ' ',$message);
        $postedAt=date("Y-m-d:i:s");
        
        $newData= $user."\t" . $message."\t" . $postedAt."\n";
        
        $fp=fopen($dataFile, "a");
        fwrite($fp, $newData);
        fclose($fp);
    }
    }
// else{
// setToken();
//  }

$posts=file($dataFile, FILE_IGNORE_NEW_LINES);
$posts=array_reverse($posts);
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
            <input type="submit" value="投稿">
            <!-- <input type="hidden" name="token" vlaue="<?php echo h($_SESSION["token"]); ?>"> -->
        </form>
    </section>

    <section>
        <h2>これまでの投稿一覧(<?php echo count($posts); ?>件)</h2>
        <ul>
            <?php if (count($posts)): ?>
                <?php foreach ($posts as $post): ?>
                <?php list($user,$message,$postedAt)=explode("\t", $post); ?>
                    <li>(<?php echo h($user); ?>):<?php echo h($message); ?>-<?php echo h($postedAt); ?></li>
                <?php endforeach ?>
                   
            <?php else : ?> 
            <li>まだ投稿はありません</li>
            <?php endif; ?>
            
        </ul>

    </section>
</body>

</html>