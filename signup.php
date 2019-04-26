<?php

session_start();

$db['host']="localhost";
$db['user']="still";
$db['pass']="Rose0314@";
$db['dbname']="bbs";

$errorMessage="";
$signUpMessage="";

if(isset($_POST["signUp"])){

    if(empty($_POST["username"])){
        $errorMessage="ユーザー名が未入力です。";
    }else if(empty($_POST["email"])){
        $errorMessage="メールアドレスが未入力です。";
    }else if(empty($_POST["password"])){
        $errorMessage="パスワードが未入力です。";
    }else if(empty($_POST["password2"])){
        $errorMessage="パスワードを2回入力してください。これはパスワードの入力ミスを防ぐためです。";
    }else if($_POST["password"] != $_POST["password2"]){
        $errorMessage="再入力されたパスワードが一致していません。";
    }else{
    
        $username=$_POST["username"];
        $email=$_POST["email"];
        $password=$_POST["password"]; 
    
        $dsn=sprintf('mysql:dbname=%s;host=%s;charset=utf8mb4', $db['dbname'], $db['host'] );
        
        try{
            $pdo=new PDO($dsn, $db['user'],$db['pass'],array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
        
            $stmt=$pdo->prepare("INSERT INTO UserData(username, email, password) VALUES(?,?,?)");
            
            $stmt->execute(array($username, $email, password_hash($password, PASSWORD_DEFAULT)));

            $signUpMessage="登録が完了しました。あなたの登録メールアドレスは`$email`です。パスワードは`$password`です。";
        }catch (PDOException $e){
            $errorMessage="データベースエラー";
            $e->getMessage();
            echo $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>

<html lang="ja">

<head>
    <meta charset="utf-8">
    <title>新規登録</title>
</head>

<body>
    <h1>新規登録画面</h1>
    <form id="loginForm" name="loginForm" action="" method="POST">
        <fieldset>
            <legend>新規登録フォーム</legend>
            <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
            <div><font color="#0000ff"><?php echo htmlspecialchars($signUpMessage,ENT_QUOTES); ?></font></div>
            <label for="username">ユーザー名</label><input type="text" id="username" name="username" placeholder="ユーザー名を入力" value="<?php if (!empty($_POST["username"])){echo htmlspecialchars($_POST["username"],ENT_QUOTES);} ?>">
            <br>
            <label for="email">メールアドレス</label><input type="text" id="email" name="email" placeholder="メールアドレスを入力" value="<?php if (!empty($_POST["email"])){echo htmlspecialchars($_POST["email"],ENT_QUOTES);} ?>">
            <br>
            <label for="password">パスワード</label><input type="password" id="password" name="password" value="" placeholder="パスワードを入力">
            <br>
            <label for="password2">パスワード(確認用)</label><input type="password" id="password2" name="password2" value="" placeholder="再度パスワードを入力">
            <br>
            <input type="submit" id="signUp" name="signUp" value="新規登録">
        </fieldset>

    </form>

    <br>
    <form action="login.php">
        <input type="submit" value="戻る">
    </form>


</body>

</html>




