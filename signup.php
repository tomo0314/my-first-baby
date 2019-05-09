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
    <link rel="stylesheet" type="text/css" href="CSS/styles_signup.css">
    <title>Sign Up</title>
</head>

<body>
    <div class="form-wrapper">
    <h1>Sign Up</h1>
    <form id="loginForm" name="loginForm" action="" method="POST">
        <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
        <div><font color="#0000ff"><?php echo htmlspecialchars($signUpMessage,ENT_QUOTES); ?></font></div>
        <div class="form-item">   
            <label for="username">Name</label>
            <input type="text" id="username" name="username" placeholder="ユーザー名を入力" value="<?php if (!empty($_POST["username"])){echo htmlspecialchars($_POST["username"],ENT_QUOTES);} ?>">
            <br>
        </div>
        <div class="form-item">
            <label for="email">E-mail</label>
            <input type="text" id="email" name="email" placeholder="メールアドレスを入力" value="<?php if (!empty($_POST["email"])){echo htmlspecialchars($_POST["email"],ENT_QUOTES);} ?>">
            <br>
        </div>
        <div class="form-item">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" value="" placeholder="パスワードを入力">
            <br>
        </div>
        <div class="form-item">
            <label for="password2">Password(again)</label>
            <input type="password" id="password2" name="password2" value="" placeholder="再度パスワードを入力">
            <br>
        </div>
        <div class="button-panel">
            <input type="submit" id="signUp" class="button" name="signUp" value="Sign Up">
        </div>
    </form>

    <br>
    <div class="form-footer">
        <p><a href="login.php">Sign In</p>
    </div>

</div>
</body>

</html>




