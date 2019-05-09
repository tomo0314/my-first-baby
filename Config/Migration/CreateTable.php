<?php
require_once (__DIR__ . '/../config.php');

/**
 * テーブルの新規作成や削除をコード上で行うためのクラス
 *
 * 実行する場合、コマンドラインから
 *  php /path/to/CreateTable.php up
 *  php /path/to/CreateTable.php down
 * のように使用してください。
 *
 * up を指定した場合はテーブル作成、down を指定した場合はテーブルの削除を行います。
 * ※ down コマンドを実行した場合はテーブルに含まれるすべてのデータが削除されてしまいます。
 *
 * このクラスを使用する前に、Config/config.php のデータベース設定を記入してください。
 *
 * テーブルを新しく追加したい場合は、このクラスの
 *  _getUpSqls / _getDownSqls
 * メソッドの内容を書き換えて、コマンドラインから再度実行してください。
 *
 * 本来であればトランザクション等を考慮しなければいけないですが、簡単のために省略しています。
 */

class CreateTable
{
    /** 
     * テーブル作成を行うコマンドの作成
     *@return bool #論理値のテーブルであることの説明
     */
    public function up(){
        $db = $this->_connect();
        if(!$db){
            echo "データベース接続に失敗しました\n";
        }
        //実行するsql文をすべて取得
        $sqls=$this->_getUpSqls();

        //sql文を一つずつ実行するためにループを回す
        foreach ($sqls as $sql){

            //sql文を実行
            $r=$db->query($sql);

            //途中でエラーがあった場合はエラー表示して終了
            if(!$r){
                echo "テーブル作成に失敗しました\n";
                return false;
            }
        }

        //最後までエラーがなかったら成功
        echo "テーブルをすべて作成しました\n";
        return true;
    }

    /** 
     * テーブル削除を行うコマンドの作成
     * @return bool
    */
    public function down(){
        $db = $this->_connect();
        if(!$db){
            echo "データベース接続に失敗しました\n";
        }

        //実行するsql文をすべて取得
        $sqls=$this->getDownSqls();

        //sql文を一つずつ実行するためにループを回す
        foreach($sqls as $sql){

            //sql文を実行
            $r = $db->query($sql);

            //途中でエラーがあった場合はエラー表示して終了
            if(!$r){
                echo "テーブル削除に失敗しました\n";
                return false;
            }
        }

        //最後までエラーがなかったら成功
        echo "テーブルをすべて削除しました\n";
        return true;
    }

    /**
     * データベースに接続
     * 失敗したときにはfalseを返します。
     * 
     * @return bool|PDO
     */
    private function _connect(){
        try{
            $config = getGrobalConfig();
            $db = new PDO(
                'mysql:host=' . $config['mysql']['host'] . ';dbname=' . $config['mysql']['dbname'] . '; charset=utf8',
                $config['mysql']['username'],
                $config['mysql']['password']);
            return $db;
        }catch (Exception $e){
            //本来なら例外を握りつぶすべきではない
            return false;
        }
    }

    /**
     * テーブルを取得するsql文を取得
     * @param string $name テーブル名
     * @param array $params ['id int(11) auto_increment primary key'....]の形式の配列
     * @return string
     */

     private function _getCreateTableSql($name, array $params){
         $sql = 'create table' . ' ' . $name . '(';
         $sql .=implode(',',$params);
         $sql .=')';
         return $sql;
     }

    /**
     * テーブルを削除するsql文を取得
     * @param string $name テーブル名
     * @return string
     */
     private function _getDropTalbeSql($name){
         $sql= 'drop table' . ' ' . $name;
         return $sql;
     }

     /**
      * テーブルを作成するためにSQL分をすべて取得する
      * @return array
      */
      private function _getUpSqls(){
          $sqls = [];
          $sqls[] = $this->_getCreateTableSql('UserData',[
              'id int(5) unsigned auto_increment primary key',
              'username varchar(100)',
              'email varchar(200)',
              'password varchar(100)'
          ]);
          $sqls[] = $this->_getCreateTableSql('articles',[
              'id int(10) auto_increment primary key',
              'username varchar(100)',
              'message varchar(100)',
              'postedAt datetime'
          ]);
          return $sqls;
      }

      /**
       * テーブル削除を行うためのSQL分をすべて取得する
       * @return array
       */
      private function _getDwonSqls(){
          $sqls = [];
          $sqls[] = $this->_getDropTableSql('UserData');
          $sqls[] = $this->_getDropTalbeSql('articles');
          return $sqls;
      }
}

$migration = new CreateTable();
$option = isset($argv[1]) ? $argv[1] : '';

if($option ==='up'){
    $migration->up();
}else if ($option==='down'){
    $migration->down();
}else{
    echo "up(テーブル作成用)もしくはdown(テーブル削除用)の引数を指定してください。\n";
}