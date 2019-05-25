<?php

require_once (__DIR__. '/../Db/DbBase.php');

/**
 * TOP画面（掲示板画面）の挙動を司るphpの動きを関数化する
 */
class IndexController
{
    /**
     * エラーメッセージ
     * @var string 
     */
    private $_errorMessage;

    /**
     * 投稿読み込みの戻り値
     * @var string 
     */
    public $_articles;

    /**
     * 実際のページロジックを実行
     */

    public function execute(){

        session_start();

        /**
         * 投稿の読み込み設定
        */


        #データベース接続
        $table=Db::getArticlesTable();
        if(!$table){
            die('データベース接続エラー');
        }
        
        #投稿の読み込み
        $this->_articles = $table->SelectMessage();
        
        #理由はよくわからないが投稿の読み込みに失敗した場合のエラー表示
        if(!$this->_articles){
            $this->_errorMessage="投稿の読み込みに失敗しました";
        }


        /**
         * 投稿の書き込み設定
         */
        if (isset($_POST['regist'])){
           
            //必要なパラメータが揃っているか確認
            //メッセージの確認
            if (empty($_POST["message"])){
                $this->_errorMessage="本文を入力してください。";
                return;
            }
            
            #ログインの有無の確認
            if(!isset($_SESSION["username"])){
                $this->_errorMessage="書き込みをするためには、ログインが必要です。";
                return;
            }

            #CSRF対策：トークンの認証
            if(!CsrfValidator::checkToken(filter_input(INPUT_POST, 'token_post'))){
            header('Content-Type: text/plain; charset=UTF-8', true, 400);
            die ('不正なPOSTが行われました。');
            }
            
            #ユーザー名・本文の取得
            $username=($_SESSION["username"]);
            $message=($_POST["message"]);
    
            #投稿時刻の取得
            date_default_timezone_set('Asia/Tokyo');
            $postedAt=date("Y-m-d H:i:s");
    
            #データベースへの接続
            $table=Db::getArticlesTable();
            if(!$table){
                die('データベース接続エラー');//メッセージを表示してスクリプト終了
            }
    
            #INSERT
            $r = $table->InsertMessage($username,$message,$postedAt);
            
            #理由はよくわからないが挿入に失敗した場合のエラー表示
            if(!$r){
                $this->_errorMessage="投稿に失敗しました";
            }
                
            #INSERT後、ページを更新
            $this->_redirectToMyself();

        }

        /**
         *投稿の削除設定
         */
        if (isset($_POST['delete'])){

            $delete_username = $_POST['delete_username'];

            //ログインの確認
            if(!isset($_SESSION['username'])){
                $this->_errorMessage="投稿の削除にはログインが必要です。";
                return;    
            }
            
            //書き込んだユーザーのみ削除可能に設定
            if($_SESSION['username'] !== $delete_username){
                $this->_errorMessage="書き込んだユーザーのみ削除をすることができます。";
                return;
            }

            #CSRF対策：トークンの認証
            if(!CsrfValidator::checkToken(filter_input(INPUT_POST, 'token_delete'))){
            header('Content-Type: text/plain; charset=UTF-8', true, 400);
            die ('不正なPOSTが行われました。');
            }

            //データベース接続
            $table=Db::getArticlesTable();
            if(!$table){
                die('データベース接続エラー');
            }
            
            //deleteの実行
            try{
                $delete_id=$_POST['delete_id'];
                $table->DeleteMessage($delete_id);
            }catch(PDO $e){
                $this->_errorMessage="投稿の削除に失敗しました。";
            }

            //投稿完了のメッセージ
            $this->_errorMessage="削除が完了しました。";


            #INSERT後、ページを更新
            $this->_redirectToMyself();
            exit;
          
        }
    }   
    
    /**
    * ページにリダイレクト（再読込）
    * これはPOSTでアクセスされたとき、二重に処理されるのを防ぐため。
     * @return bool
     */
    private function _redirectToMyself(){
        header("Location: " .$_SERVER['PHP_SELF'],true,301);
        exit();
    }

    
    /**
    * html表示の段階で使うパラメータの設定
    * @param $errorMessage
    */
    private function _errorMessage(){
        $this->_errorMessage = $errorMessage;
    }
    

    /**
    * html表示に使用するパラメータを取得
    * @return array
    */
    public function getErrorMessage(){
        return $this->_errorMessage;
    }

    /**
    * html表示に使用するパラメータを取得
    * @return array
    */
    public function getArticles(){
        return $this->_articles;
    }
}
