<?php 

require_once (__DIR__.'/TableBase.php');

class ArticlesTable extends TableBase
{
    /**
     * Index:メッセージ書き込みのsql文
     *
     * @param string $username
     * @param string $message
     * @param string $postedAt
     * @return bool
     */
    public function InsertMessage($username,$message,$postedAt){
        $prepare=$this->_prepareInsert('articles', '(username, message, postedAt) VALUES(:username,:message,:postedAt)');
        $prepare->bindParam(':username',$username, PDO::PARAM_STR);
        $prepare->bindParam(':message',$message,PDO::PARAM_STR);
        $prepare->bindParam(':postedAt',$postedAt,PDO::PARAM_INT);
        return $prepare->execute();
    }

    /**
     * Index:メッセージ読み込みのsql文
     * @return bool
     */
    public function SelectMessage(){
        try {
            $stmt=  $this->_pdo->query('select * from articles ORDER BY id DESC');
            return  $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "eroor: ".$e;
        }
    }


    /**
     * Index:メッセージ削除のsql文
     * @param int $delete_id
     * @return bool
     */
    public function DeleteMessage($delete_id){
        $prepare=$this->_prepareDelete('articles', 'where id=:delete_id');
        $r=$prepare->bindParam(':delete_id',$delete_id,PDO::PARAM_INT);
        return $prepare->execute();
    }


    /**
     * SignUp:ユーザーネーム・メールアドレス・パスワードを指定して新規ユーザーを作成する
     * @param string $uesrname ユーザー名
     * @param string $email  SQLインジェクション対策を内部的に行っているので、平文で指定してください
     * @param string $password 内部的に暗号化を行っているので、平文で指定してください
     * @return bool
     */
    public function InsertNewUser($username,$email,$password){
        $password = password_hash($password, PASSWORD_DEFAULT);
        $prepare = $this->_prepareInsert('UserData', '(username, email, password) values (:username, :email, :password)');
        $prepare->bindParam(':username', $username, PDO::PARAM_STR);
        $prepare->bindParam(':email', $email, PDO::PARAM_STR);
        $prepare->bindParam(':password', $password, PDO::PARAM_STR);
        return $prepare->execute();
    }
    /**
     * Login:メールアドレスの照合とユーザー情報の引き出し
     *
     * @param string $email
     * @return bool
     */
    public function SelectEmail($email){
        $prepare = $this->_prepareSelect('UserData','where email=:email');
        $prepare->bindParam(':email',$email,PDO::PARAM_STR);
        $prepare->execute();
        return $prepare->fetch(PDO::FETCH_ASSOC);
    }
}