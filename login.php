<?php

session_start();

if (isset($_SESSION['username'])){
    header('Location: index.php');
    exit();
}
#データベースの設定
$db['host']="localhost";
$db['user']="still";
$db['pass']="Rose0314@";
$db['dbname']="bbs";

#エラーメッセージの初期化
$errorMessage="";

#ログインボタンpush後の処理
if (isset($_POST["login"])){
    
    if (empty($_POST["email"])){
        $errorMessage="メールアドレスが未入力です。";
    }else if (empty($_POST["password"])){
        $errorMessage="パスワードが未入力です。";
    }

    if(!empty($_POST["email"]) && !empty($_POST["password"])){

        #データベース処理・認証 
        $email= $_POST["email"];
       
        #dsnの設定（上の$dbで変えられるよう、％ｓの変数で取る）
        $dsn=sprintf('mysql:dbname=%s; host=%s; charset=utf8mb4', $db['dbname'],$db['host'] );
    
        #エラー処理
        try{
            #データベース接続
            $pdo= new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));      
            
            #データベースにあるemailとの照合
            $stmt= $pdo->prepare("SELECT * FROM UserData WHERE email=?");
            $stmt->execute(array($email));

            $password=$_POST["password"];

            #一致したuserのデータを連想配列で取得
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $hash_pass=$result['password'];
                
            #パスワード認証
            if (password_verify($password, $hash_pass)){
                session_regenerate_id(true);//認証終わり

                #入力したemailのユーザー名を取得 
                $username=$result['username'];
                $_SESSION['username']=$username;
                header("Location: index.php");
                exit();
               
            }else{
                $errorMessage="メールアドレスまたはパスワードに誤りがあります。";
            }
        #例外処理    
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
    <link rel="stylesheet" type="text/css" href="CSS/styles_login.css">
    <title>Sign In</title>
</head>

<body>
    <div class="form-wrapper">
    <h1>Sign In</h1>
    <form id="loginForm" name="loginForm" action="" method="POST">
      
        <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
        
        <div class="form-item">
            <label for="email">E-mail</label>
            <input type="text" id="email" name="email" placeholder="メールアドレスを入力" value="<?php if (!empty($_POST["email"])){echo htmlspecialchars($_POST["email"],ENT_QUOTES);} ?>">
        </div>

        <div class="form-item">
        <label for="password">password</label>
        <input type="password" id="password" name="password" value="" placeholder="パスワードを入力">
        </div>
        
        <div class="button-panel">
        <input type="submit" id="login" class="button" name="login" value="SIGN IN">
        </div>
    </form>
    <br>

    <div class="form-footer">
        <p><a href="signup.php">Create an account</a></p>
    </div>
</body>


</html>
