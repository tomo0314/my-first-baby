<?php 

/*
ユーザーテーブル取得と、データベース接続のための関数設定
*/

require_once dirname(__FILE__) . '/../../Config/config.php';
require_once 'Table/UserTable.php';

class Db
{   
    /**
     * ユーザーテーブルを取得
     * @return Usertable|null
     */
    static public function getUserTable(){
        $pdo = self::_connect();
        if(!$pdo){
            return null;
        }
        return new UserTable($pdo);
    }

    /**
     * データベースに接続
     * 失敗したときはfalseを返す
     * @return bool|PDO
     */
    static private function _connect(){
        try{
            $config = getGlobalConfig();
            $db = new PDO(
                'mysql:host=' . $config['mysql']['host'] . ';dname=' . $config['mysql']['dbname'] . '; charset=utf8',
                $config['mysql']['username'],
                $config['mysql']['password']);
            return $db;
        }catch (Exception $e){
            return $false;
        }
    }
}