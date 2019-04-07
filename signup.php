<!DOCTYPE html>

<html lang="ja">

<head>
<meta charset="utf-8">
<tile>新規登録</tile>
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
            <label for="password">パスワード</label><input type="password" id="password" name="password" value="" placeholder="パスワードを入力">
            <br>
            <label for="password2">パスワード(確認用)</label><input type="password" id="password2" name="password2" value="" placeholder="パスワードを入力">
            <br>
            <input type="submit" id="signUp" name="signUp" value="新規アカウント登録">
        </fieldset>

    </form>

    <br>
    <form action="Login.php">
        <input type="submit" value="戻る">
    </form>


</body>

</html>




