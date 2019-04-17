<?php

session_start();

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

    #データベース処理・認証
    if(!empty($_POST["email"]) && !empty($_POST["password"])){
        
        $email= $_POST["email"];
       
        #dsnの設定（上の$dbで変えられるよう、％ｓの変数で取る）
        $dsn=sprintf('mysql:dbname=%s; host=%s; charset=utf8mb4', $db['dbname'],$db['host'] );
    
        #エラー処理
        try{
            #データベース接続
            $pdo= new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
            
            #データベースにあるemailとの照合
            $stmt= $pdo->prepare("SELECT * FROM UserData WHERE name=?");
            $stmt->execute(array($email));
            
            $password= $$_POST["password"];

            #emailが見つかった後のパスワード認証
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                
                #パスワード認証
                if (password_verify($password, $row['password'])){
                    session_regenerate_id(true);//認証終わり

                    #入力したemailのユーザー名を取得
                    $email=$row['email'];
                    $sql="SELECT * FROM UserData WHERE email=$email";
                    $stmt=$pdo->query($sql);

                    foreach ($stmt as $row){
                        $row['usename'];
                    }
                    
                    $_SESSION["USERNAME"]=$row['username'];
                    header("Location: index.php");
                    
                    exit();
                }else{
                    $errorMessage="メールアドレスあるいはパスワードに誤りがあります。";
                }
            }else{
                $errorMessage="メールアドレスあるいはパスワードに誤りがあります。";
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
    <title>ログイン</title>
</head>

<body>

    <h1>ログイン画面</h1>
    <form id="loginForm" name="loginForm" action="" method="POST">

        <fieldset>
            <legend>ログインフォーム</legend>
            <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
            <label for="email">メールアドレス</label><input type="text" id="email" name="email" placeholder="メールアドレスを入力" value="<?php if (!empty($_POST["email"])){echo htmlspecialchars($_POST["email"],ENT_QUOTES);} ?>">
            <br>
            <label for="password">パスワード</label><input type="password" id="password" name="password" value="" placeholder="パスワードを入力">
            <br>
            <input type="submit" id="login" name="login" value="ログイン">
        </fieldset>
    </form>
    <br>

    <form action="signup.php">
        <fieldset>
            <legend>新規アカウント登録</legend>
            <input type="submit" value="新規登録">
        </fieldset>
        
    </form>



</body>


</html>
