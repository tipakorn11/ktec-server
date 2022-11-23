<?php

use \Firebase\JWT\JWT;

class JwtHandler
{
    protected $jwt_secrect;
    protected $token;
    protected $issuedAt;
    protected $expire;
    protected $jwt;

    public function __construct()
    {
        // set your default time-zone
        date_default_timezone_set('Asia/Bankkok');
        $this->issuedAt = time();

        // Token Validity (3600 second = 1hr)
        //set token 1 day
        $this->expire = $this->issuedAt + 86400;

        // Set your secret or signature
        $this->jwt_secrect = "solo_tipakorn";
    }

    // ENCODING THE TOKEN
    public function _jwt_encode_data($iss, $data)
    {

        $this->token = array(
            //Adding the identifier to the token (who issue the token)
            "iss" => $iss,
            "aud" => $iss,
            // Adding the current timestamp to the token, for identifying that when the token was issued.
            "iat" => $this->issuedAt,
            // Token expiration
            "exp" => $this->expire,
            // Payload
            "data" => $data
        );

        $this->jwt = JWT::encode($this->token, $this->jwt_secrect);
        return $this->jwt;
    }

    //DECODING THE TOKEN
    public function _jwt_decode_data($jwt_token)
    {
        try {
            $decode = JWT::decode($jwt_token, $this->jwt_secrect, array('HS256'));
            return [
                "auth" => 1,
                "data" => $decode->data,
                "require" => true
            ];
        } catch (\Exception $e) {
            return [
                "auth" => 0,
                "data" => [],
                "require" => false
            ];
        }
    }
    public function fetchUser($username)
    {
        try {
            $db = new db();
            $db = $db->connect();

            $sql = $db->prepare("SELECT * FROM user WHERE username = :username");
            $sql->bindParam(':username', $username);
            $sql->execute();
            $user = $sql->fetchAll(PDO::FETCH_OBJ);
            $db = null;
            if (!$user) {
                return false;
            } else {
                return true;
            }
        } catch (PDOException $e) {
            // show error message as Json format
            echo '{"error": {"msg": ' . $e->getMessage() . '}';
        }
    }
    public function isAuth($data)
    {
        try {
            $jwt = new JwtHandler();
            $decode = $jwt->_jwt_decode_data($data);
            if($decode['auth']){
                if($this->fetchUser($decode['data']->id)){
                    return $decode;   
                }else{
                    return [
                        "auth" => 0,
                        "data" => [],
                        "require" => false
                    ];
                }
            }else{
                return $decode;
            }
        } catch (\Exception $e) {
            // show error message as Json format
            echo '{"error": {"msg": ' . $e->getMessage() . '}';
        }
    }
}