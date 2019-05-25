<?php 

/*
ユーザーテーブルクラス取得と、データベース接続のための関数設定
*/

require_once (__DIR__. '/../Config/config.php');
require_once 'Table/UserdataTable.php';
require_once 'Table/ArticlesTable.php';
require_once (__DIR__. '/../csrf.php');


class Db
{   
    /**
     * データベースに接続＆ユーザーデータクラスを取得
     * @return UserdataTable|null
     */
    static public function getUserdataTable(){
        $pdo = self::_connect();
        if(!$pdo){
            return null;
        }
        return new UserdataTable($pdo);
    }

    /**
     * データベースに接続＆アーティクルクラスを取得
     * @return ArticlesTable|null
     */
    static public function getArticlesTable(){
        $pdo = self::_connect();
        if(!$pdo){
            return null;
        }
        return new ArticlesTable($pdo);
    }

    /**
     * データベースに接続
     * 失敗したときはfalseを返す
     * @return bool|PDO
     */
    static private function _connect(){
        try{
            $config = getGrobalConfig();
            $dsn = new PDO(
                'mysql:host=' . $config['mysql']['host'] . ';dbname=' . $config['mysql']['dbname'] . '; charset=utf8',
                $config['mysql']['username'],
                $config['mysql']['password']);
            return $dsn;
        }catch (Exception $e){
            return false;
             // TODO: 本来なら例外を握りつぶすべきではないが、仮でこうしておく
        }
    }
}