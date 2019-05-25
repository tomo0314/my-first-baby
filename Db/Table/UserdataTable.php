<?php 

require_once (__DIR__.'/TableBase.php');

class UserdataTable extends TableBase
{

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