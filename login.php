<?php

session_start();

$db['host']="localhost";
$db['user']="still";
$db['pass']="Rose0314@";
$db['dbname']="loginManagement";


$errorMessage="";

if (isset($_POST["login"])){
    if (empty($_POST["userid"])){
        $errorMessge="ユーザーIDが未入力です。";
    }else if (empty($_POST["password"])){
        $errorMessage="パスワードが未入力です。";
    }

    if(!empty($_POST["userid"]) && !empty($_POST["password"])){
        
        $userid= $_POST["userid"];

        $dsn=sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'],$db['dbname']);
    
        try{
            $pdo= new PDO($dsn,$db['user'],$db['pass'],array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
            $stmt= $pdo->prepare("SELECT*FROM UserData WHERE name=?");
            $stmt->execute(array($userid));
            $password= $$_POST["password"];

            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                if (password_verify($password, $row['password'])){
                    session_regenerate_id(true);

                    $id=$row['id'];
                    $sql="SELECT*FROM UserData WHERE id=$id";
                    $stmt=$pdo->query($sql);

                    foreach ($stmt as $row){
                        $row['name'];
                    }
                    
                    $_SESSION["NAME"]=$row['name'];
                    header("Location: index.php");
                    
                    exit();
                }else{
                    $errorMessage="ユーザーIDあるいはパスワードに誤りがあります。";
                }
            }else{
                $errorMessage="ユーザーIDあるいはパスワ度に誤りがあります。";
            }
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
            <label for="userid">ユーザーID</label><input type="text" id="userid" name="userid" placeholder="ユーザーIDを入力" value="<?php if (!empty($_POST["userid"])){echo htmlspecialchars($_POST["userid"],ENT_QUOTES);} ?>">
            <br>
            <label for="password">パスワード</label><input type="password" id="password" name="password" value="" placeholder="パスワードを入力">
            <br>
            <input type="submit" id="login" name="login" value="ログイン">
        </fieldset>
    </form>
    <br>

    <form action="signUp.php">
        <fieldset>
            <legend>新規アカウント登録</legend>
            <input type="submit" value="新規登録">
        </fieldset>
        
    </form>



</body>


</html>
