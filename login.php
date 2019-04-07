<!DOCTYPE html>

<html lang="ja">

<head>
    <meta charset="utf-8">
    <tile>ログイン</tile>
</head>

<body>

    <h1>ログイン画面</h1>
    <form id="loginForm" name="loginForm" action="" method="POST">

        <fieldset>
            <legend>ログインフォーム</legend>
            <div><font color="ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
            <label for="userid">ユーザーID</label><input type="text" id="userid" name="userid" placeholder="ユーザーIDを入力" value="<? if (!empty($_POST["userid"])){echo htmlspecialchars($_POST["userid"],ENT_QUOTES);} ?>">
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
