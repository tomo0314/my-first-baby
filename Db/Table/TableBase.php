<?php 

require_once ( __DIR__ . '/../Config/config.php');

// Controllor.phpで用いる、MySQLのselect/insertのprepare関数の設定

class TableBase
{
    /**
     * @var PDO
     */
    protected $_pdo;

    /**
     * @param PDO $pdo;
     */
    function __construct(PDO $pdo){
        $this->_pdo = $pdo;
    }

    /**
     * select文のprepare
     *@param string $table テーブル名
     * @param string $param where区など
     * @return bool | PDOStatement
     */
    protected function _prepareSelect($table, $param=''){
        $sql='select * from' . ' ' . $table . ' ' . $param;
        return $this->_pdo->prepare($sql);
    }

    /**
     * insert文のprepare
     * @param string $table テーブル名
     * @param string $param where区など
     * @return bool | PDOStatement
     */
    protected function _prepareInsert($table, $param){
        $sql = 'insert into' . ' ' . $table . $param;
        return $this ->_pdo->prepare($sql);
    }
}
