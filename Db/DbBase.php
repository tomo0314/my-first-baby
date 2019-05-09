<?php 

require_once dirname(__FILE__) . '/../../Config/config.php';
require_once 'Table/UserTable.php';

class Db
{
    static public function getUserTable(){
        $pdo = self::_connect();
        if(!pdo){
            return null;
        }
        return new UserTable($pdo);
    }
}