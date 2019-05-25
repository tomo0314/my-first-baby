<?php

class CsrfValidator{  

    //ハッシュ化の方法選択
    const HASH_ALGO = 'sha256';

    /**
     * トークンをセットする関数の設定
     *
     * @param string $session_id
     */
    public static function setToken(){
        if (session_status() === PHP_SESSION_NONE){
            throw new \BadMethodCallException('セッションが有効になっていません。');
            return;
        }
        return hash(self::HASH_ALGO, session_id());
    }


    /**
     * トークンを認証する関数の設定
     * 
     * @param string $success
     * @return bool  
     */public static function checkToken($token, $throw = false){
        $success = self::setToken() === $token;
        if(!$success && $throw){
            throw new \RuntimeException('トークンの認証に失敗しました。',400);
            exit;
        }
        return $success;
    }

}