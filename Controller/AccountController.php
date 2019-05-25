<?php

require_once (__DIR__. '/../Db/DbBase.php');

/**
 * アカウント画面（ログイン・ログアウト・サインアップ画面）の挙動を司る
 */

class AccountController
{
    /**
    * @var string エラーメッセージ
    */
    private $_errorMessage;

    /**
    * @var string サインアップメッセージ
    */
    private $_signupMessage;


    /**
    * @var string ログインユーザーデータ
    */
    private $_uesrdata;

    //ログイン機能の実装
    public function login(){
        session_start();

        if (isset($_POST["login"])) {
            if (empty($_POST["email"])) {
                $this->_errorMessage="メールアドレスが未入力です。";
                return;
            }
        
            if (empty($_POST["password"])) {
                $this->_errorMessage="パスワードが未入力です。";
                return;
            }

            #emailの取得
            $email= $_POST["email"];

            #データベース接続
            $table=Db::getUserdataTable();
            if (!$table) {
                die('データベース接続エラー');
            }
                       
            #データベースにあるemailとの照合
            $this->_userdata = $table->SelectEmail($email);

            if (!$this->_userdata) {
                $this->_errorMessage="メールアドレスの照合に失敗しました";//適切なエラーメッセージに変更
                return;
            }

            $password=$_POST["password"];

            #ハッシュ化したパスワードを取得
            $hash_pass=$this->_userdata['password'];
                
            #パスワード認証
            if (password_verify($password, $hash_pass)) {
                session_regenerate_id(true);//認証終わり

                #入力したemailのユーザー名を取得
                $username=$this->_userdata['username'];
                $_SESSION['username']=$username;
                header("Location: index.php");
                exit();
            }
        }
    }

    //ログアウト機能の実装
    public function logout(){
        session_start();

        if(isset($_SESSION["username"])){
            $this->_errorMessage="ログアウトしました";
        }else{
            $this->_errorMessage="セッションがタイムアウトしました";
        }
        
        #セッション変数（ユーザーの情報）を空の配列によって初期化する
        $_SESSION=array();
        
        #cookie（ブラウザ）上のユーザーデータも削除
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time()-42000, '/');
        }
        
        #ユーザーのサーバーからのセッションの削除
        session_destroy();
    }


    public function signup(){
        if (isset($_POST["signUp"])) {
            
            session_start();

            if (empty($_POST["username"])) {
                $this->_errorMessage="ユーザー名が未入力です。";
                return;
            }
            
            if (empty($_POST["email"])) {
                $this->_errorMessage="メールアドレスが未入力です。";
                return;
            }
            
            if (empty($_POST["password"])) {
                $this->_errorMessage="パスワードが未入力です。";
                return;
            }
            
            if (empty($_POST["password2"])) {
                $this->_errorMessage="パスワードを2回入力してください。これはパスワードの入力ミスを防ぐためです。";
                return;
            }
            
            if ($_POST["password"] != $_POST["password2"]) {
                $this->_errorMessage="再入力されたパスワードが一致していません。";
                return;
            }
            
            #ユーザー情報の取得
            $username=$_POST["username"];
            $email=$_POST["email"];
            $password=$_POST["password"];
                
            #データベース接続
            $table=Db::getUserdataTable();
            if (!$table) {
                die('データベース接続エラー');
            }
            
            $result = $table->InsertNewUser($username, $email, $password);
            $this->_signupMessage="登録が完了しました。あなたの登録メールアドレスは $email です。パスワードは $password です。";
        }
    }
    


    /**
    * html表示の段階で使うパラメータの設定
    * @param $errorMessage
    */
    private function _errorMessage()
    {
        $this->_errorMessage = $errorMessage;
    }

    /**
    * html表示に使用するパラメータを取得
    * @return array
    */
    public function get_errorMessage()
    {
        return $this->_errorMessage;
    }

    public function get_signupMessage()
    {
        return $this->_signupMessage;
    }
}


