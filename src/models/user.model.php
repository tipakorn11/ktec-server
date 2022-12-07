<?php
class UserModel
{
    //แสดงผู้ใช้
    public function getUserBy($data)
    {
        try {
            // Get DB Object
            $db = new db();
            // connect to DB
            $db = $db->connect();
            // query
            $sql = "SELECT * FROM User WHERE TRUE";
            if(isset($data[''])){
                
            }
            // if(isset($data['params']['filters'])){
            //     if($data['params']['filters']['building_id']){
            //         $sql .= " AND building_id LIKE '%".$data['params']['filters']['building_id']."%' ";
            //     }
            //     if($data['params']['filters']['faculty_name']){
            //         $sql .= " AND building_name LIKE '%".$data['params']['filters']['building_name']."%' ";
            //     }
            // }
            $query = $db->query($sql);
            $result = $query->fetchAll(PDO::FETCH_OBJ);
            $count = count($result);
            echo $data;
            // if(isset($data['params']['pagination'])){
            //     $sql .= " LIMIT ".($data['params']['pagination']['current']* $data['params']['pagination']['pageSize'] - $data['params']['pagination']['pageSize']).",".($data['params']['pagination']['pageSize'])."";
            // }
            // $query = $db->query($sql);
            // $result = $query->fetchAll(PDO::FETCH_OBJ);
            $db = null;
            if (!$result) {
                return ['data' => [], 'require' => false];
            } else {
                return ['data' => $result, 'require' => true,'total'=>$count];
            }
        } catch (PDOException $e) {
            $db = null;
            return ['data' => [], 'require' => false];
        }
    }
    //logging in 
    public function auth($data)
    {
        try {
            $jwt = new JwtHandler();
            $decode = $jwt->isAuth($data);
            
            return $decode;
        } catch (\Exception $e) {
            // show error message as Json format
            echo '{"error": {"msg": ' . $e->getMessage() . '}';
        }
    }

    public function getUserByid($data)
    {
        try {
            // Get DB Object
            $db = new db();
            // connect to DB
            $db = $db->connect();
            // query
            $sql = $db -> prepare("SELECT *,
                                    IFNULL((SELECT prefix_name FROM prefix WHERE prefix.prefixID = user.prefixID),user.prefixID) AS prefix_name
                                    FROM user  WHERE user.personalID = :usid ");
            
            $sql->bindParam(':usid',$data['personalID']);
            $sql->execute();
            $user = $sql->fetchAll(PDO::FETCH_OBJ);

            $sql = $db -> prepare("SELECT * FROM educational WHERE personalID = :usid ");
            $sql->bindParam(':usid',$data['personalID']);
            $sql->execute();
            $educate = $sql->fetchAll(PDO::FETCH_OBJ);

            // $sql = $db -> prepare("SELECT * FROM trainning_certificate WHERE personalID = :usid ");
            // $sql->bindParam(':usid',$data['personalID']);
            // $sql->execute();
            // $training = $sql->fetchAll(PDO::FETCH_OBJ);

            $sql = $db -> prepare("SELECT * FROM useraddress WHERE personalID = :usid ");
            $sql->bindParam(':usid',$data['personalID']);
            $sql->execute();
            $useraddress = $sql->fetchAll(PDO::FETCH_OBJ);
            
            $db = null;
            if (!$user) {
                return ['data' => [], 'require' => false];
            } else {
                return ['data' => $user, 'require' => true ,'educate'=> $educate,'training'=> $training,'useraddress'=> $useraddress];
            }
        } catch (PDOException $e) {
            $db = null;
            return ['data' => 'catch', 'require' => false];
        }
    }

    public function checkLogin($data)
    {
        try {
            // Get DB Object
            $db = new db();
            // connect to DB
            $db = $db->connect();
           
            // query
            $password = md5($data['password']);
            $sql = $db->prepare("SELECT * FROM user WHERE username = :username AND password = :pass");
            $sql->bindParam(':username',$data['username']);
            $sql->bindParam(':pass',$password);
            $sql->execute();
            $user = $sql->fetchAll(PDO::FETCH_OBJ);
            if (!$user) {
                $db = null;
                return ['data' => [], 'require' => false];
            }else{
                $jwt = new JwtHandler();
                $token = $jwt->_jwt_encode_data("http://localhost/ktec-Server/public/", array("id" => $user[0]->username));
                $sql = $db->prepare("SELECT *,
                IFNULL((SELECT position_name FROM position WHERE position.positionID = user_position.positionID),user_position.positionID)AS position_name
                            FROM ktec.user_position 
                            WHERE personalID =(
                            select personalID FROM user where username = :username
                            ) ");
                $sql->bindParam(':username',$user[0]->username);
                $sql->execute();
                $position = $sql->fetchAll(PDO::FETCH_OBJ);
                


            }
            
               return ['data' =>$user,'require' => true , 'token' => $token ];
        } catch (PDOException $e) {
            // show error message as Json format
            $db = null;
            return [ 'data' => [], 'require' => false];
        }
    }
    
    public function updateUserByid($data)
    {
        try {

            // Get DB Object
            $db = new db();
            // connect to DB
            $db = $db->connect();
            // query
            $password = md5($data['password']);
            //echo $password;
            $sql = $db->prepare("INSERT INTO user (`personalID`,`username`,`password`) VALUES (:personalID,:username,:pass)");
            $sql->bindParam(':personalID', $data['personalID']);
            $sql->bindParam(':username', $data['username']);
            $sql->bindParam(':pass', $password);
           
            $sql->execute();

            $db = null;
            if (!$sql) {

                return ['data' => [], 'require' => false];
            } else {

                return ['data' => [], 'require' => true];
            }
        } catch (PDOException $e) {
            $db = null;
            echo $e->getMessage();
            return ['data' => [], 'require' => false];

        }
    }

    public function deleteUserByid($data)
    {
        try {
            $db = new db();
            $db = $db->connect();
            $sql = $db->prepare("DELETE FROM user WHERE personalID = :pid; ");
            $sql->bindParam(':pid', $data['personalID']);
            $sql->execute();
            $db = null;
            if (!$sql) {
                return [ 'require' => false];
            } else {
                return [ 'require' => true];
            }
        } catch (PDOException $e) {
            $db = null;
            echo $e->getMessage();
            return ['require' => false];
        }
    }

}
