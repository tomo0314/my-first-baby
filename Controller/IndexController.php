<?php

require_once (__DIR__. '/../Model/Db/DbBase.php');

/**
 * TOP画面（掲示板画面）の挙動を司る
 */
class IndexController
{
    /**
     * @var string エラーメッセージ
     */
    private $_errorMessage;

    /**
     * 実際のページロジックを実行
     */

     //POSTアクセス以外であれば何もしない
    public function execute(){
        
        if(!$this->_isPost()){
            return;
        }

        //必要なパラメータが揃っているか確認
        //メッセージの確認
        if (!isset($_POST["message"])){
            $this->_errorMessage="本文を入力してください。";
            return;
        }

        #ログインの有無の確認
        if(!isset($_SESSION["username"])){
            $this->_errorMessage="書き込みをするためには、ログインが必要です。";
            return;
        }
            
        #ユーザー名・本文の取得
        $username=($_SESSION["username"]);
        $message=($_POST["message"]);

        #投稿時刻の取得
        date_default_timezone_set('Asia/Tokyo');
        $postedAt=date("Y-m-d:i:s");

        #データベースへの接続
        $table=Db::getUserTable();
        if(!$table){
            die('データベース接続エラー');
        }

        #INSERT
        $r = $table->insert($email,$password);
        
        #理由はよくわからないが挿入に失敗した場合のエラー表示
        if(!$r){
            $this->_errorMessage="投稿に失敗しました";//適切なエラーメッセージに変更
        }
            
        #INSERT後、ページを更新
        _redirectToMyself();

        /**
        * アクセスがPOSTかどうか判定
        * @return bool
        */   

        private function _isPost(){
            return($_SERVER['REQUEST_METHOD']==='POST');
        }

        /**
        * ページにリダイレクト（再読込）
        * これはPOSTでアクセスされたとき、
        * 画面リロードの際に二重にPOST処理が行われることを防ぐ用途で使われる
        */

        private function _redirectToMyself(){
            header("Location: " . $_SERVER['PHP_SELF']);
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
        private function getValue(){
            return $this->_errorMessage;
        }
    }
}