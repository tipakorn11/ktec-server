<?php
class UserModel
{
    //แสดงผู้ใช้
    public function getUserBy($data)
    {
        try {
            $db = new db();
            $db = $db->connect();
            // query
            $sql = "SELECT *
                    FROM tb_user 
                    WHERE TRUE";
            
            $query = $db->query($sql);
            $result = $query->fetchAll(PDO::FETCH_OBJ);
            $count = count($result);
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
                                    IFNULL((SELECT prefix_name FROM prefix WHERE prefix.prefixID = tb_user.prefixID),tb_user.prefixID) AS prefix_name,
                                    IFNULL((SELECT course_name FROM course WHERE course.courseID = tb_user.courseID),tb_user.courseID) AS course_name



                                    FROM tb_user  
                                    WHERE tb_user.personalID = :usid ");
            
            $sql->bindParam(':usid',$data['personalID']);
            $sql->execute();
            $tb_user = $sql->fetchAll(PDO::FETCH_OBJ);

            $sql = $db -> prepare("SELECT * FROM education WHERE personalID = :pid ");
            $sql->bindParam(':pid',$data['personalID']);
            $sql->execute();
            $education = $sql->fetchAll(PDO::FETCH_OBJ);
         
            $sql = $db -> prepare("SELECT *,DATEDIFF( training_end_date,training_date) AS date_diff FROM training_certificate WHERE personalID = :usid ");
            $sql->bindParam(':usid',$data['personalID']);
            $sql->execute();
            $training = $sql->fetchAll(PDO::FETCH_OBJ);
            
            $sql = $db -> prepare("SELECT *,ifnull((SELECT position.position_name FROM position WHERE user_position.positionID = position.positionID ),positioniD ) as position_name FROM user_position WHERE personalID = :usid");
            $sql->bindParam(':usid',$data['personalID']);
            $sql->execute();
            $position = $sql->fetchAll(PDO::FETCH_OBJ);

            $sql = $db -> prepare("SELECT * FROM useraddress WHERE personalID = :usid ");
            $sql->bindParam(':usid',$data['personalID']);
            $sql->execute();
            $useraddress = $sql->fetchAll(PDO::FETCH_OBJ);
            try{
                $sql = $db -> prepare("SELECT * FROM teacher_license WHERE personalID = :usid ");
                $sql->bindParam(':usid',$data['personalID']);
                $sql->execute();
                $tl = $sql->fetchAll(PDO::FETCH_OBJ);

                $sql = $db -> prepare("SELECT * FROM teacher_permission_license WHERE personalID = :usid ");
                $sql->bindParam(':usid',$data['personalID']);
                $sql->execute();
                $tpl = $sql->fetchAll(PDO::FETCH_OBJ);

                $sql = $db -> prepare("SELECT * FROM ht_license WHERE personalID = :usid ");
                $sql->bindParam(':usid',$data['personalID']);
                $sql->execute();
                $ht_license = $sql->fetchAll(PDO::FETCH_OBJ);
            
            

            }
            catch(throwable $e){}

            try { 
                $sql = $db -> prepare("SELECT * FROM appointment WHERE personalID = :usid ");
                $sql->bindParam(':usid',$data['personalID']);
                $sql->execute();
                $appointment = $sql->fetchAll(PDO::FETCH_OBJ);
                
          
            } catch (throwable $e) {}

            try {
                $sql = $db -> prepare("SELECT * FROM portfolio WHERE personalID = :usid ");
                $sql->bindParam(':usid',$data['personalID']);
                $sql->execute();
                $portfolio = $sql->fetchAll(PDO::FETCH_OBJ);
    
              
            
            } catch (Throwable $e) {}
            
            try {
                $sql = $db -> prepare("SELECT * FROM insignia WHERE personalID = :usid ");
                $sql->bindParam(':usid',$data['personalID']);
                $sql->execute();
                $insignia = $sql->fetchAll(PDO::FETCH_OBJ);
    
            } catch (Throwable $e) {}
           
            try {
                $sql = $db -> prepare("SELECT * FROM punishment WHERE personalID = :usid ");
                $sql->bindParam(':usid',$data['personalID']);
                $sql->execute();
                $punishment = $sql->fetchAll(PDO::FETCH_OBJ);
                   
            } catch (Throwable $e) {}
           
            $db = null;
            if (!$tb_user) {
                return ['data' => [], 'require' => false];
            } else {
                return ['data' => $tb_user, 
                        'useraddress'=> $useraddress, 
                        'position' => $position,
                        'education' => $education,
                        'training' => $training,
                        'tl' => $tl,
                        'tpl' => $tpl,
                        'ht_license' => $ht_license,
                        'appointment' => $appointment,
                        'portfolio' => $portfolio,
                        'insignia' => $insignia,
                        'punishment' => $punishment,
                        'require' => true ,
                    ];
            }
        } catch (PDOException $e) {
            $db = null;
            return ['data' => 'catch', 'require' => false];
        }
    }
    public function updateUserByid($data)
    {
        try {

            $db = new db();
            $db = $db->connect();
            $sql = $db->prepare("UPDATE tb_user 
                                SET citizenID = :pname ,
                                    thai_fname = :thaifname,
                                    thai_lname = :thailname,
                                    eng_fname = :engfname,
                                    eng_lname = :englname,
                                    nationality = :nationality,
                                    bdate = :bdate,
                                    ffname = :ffname,
                                    flname = :flname,
                                    mfname = :mfname,
                                    mlname = :mlname,
                                    courseID = :cid,
                                    prefixID = :pid
                                WHERE personalID = :personalid ; ");
            $sql->bindParam(':pid', $data['prefixID']);
            $sql->bindParam(':thaifname', $data['thai_fname']);
            $sql->bindParam(':thailname', $data['thai_lname']);
            $sql->bindParam(':engfname', $data['eng_fname']);
            $sql->bindParam(':englname', $data['eng_lname']);
            $sql->bindParam(':nationality', $data['nationality']);
            $sql->bindParam(':bdate', $data['bdate']);
            $sql->bindParam(':ffname', $data['ffname']);
            $sql->bindParam(':flname', $data['flname']);
            $sql->bindParam(':mfname', $data['mfname']);
            $sql->bindParam(':mlname', $data['mlname']);
            $sql->bindParam(':cid', $data['courseID']);
            $sql->bindParam(':pid', $data['prefixID']);
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
    public function checkLogin($data)
    {
        try {
            // Get DB Object
            $db = new db();
            // connect to DB
            $db = $db->connect();
           
            // query
            $password = md5($data['password']);
            $sql = $db->prepare("SELECT * FROM tb_user WHERE username = :username AND password = :pass");
            $sql->bindParam(':username',$data['username']);
            $sql->bindParam(':pass',$password);
            $sql->execute();
            $tb_user = $sql->fetchAll(PDO::FETCH_OBJ);
            if (!$tb_user) {
                $db = null;
                return ['data' => [], 'require' => false];
            }else{
                $jwt = new JwtHandler();
                $token = $jwt->_jwt_encode_data("http://localhost/ktec-Server/public/", array("id" => $tb_user[0]->username));
                $sql = $db->prepare("SELECT *,
                IFNULL((SELECT position_name FROM position WHERE position.positionID = user_position.positionID),user_position.positionID)AS position_name
                            FROM user_position 
                            WHERE personalID =(
                            select personalID FROM tb_user where username = :username
                            ) ");
                $sql->bindParam(':username',$tb_user[0]->username);
                $sql->execute();
                $position = $sql->fetchAll(PDO::FETCH_OBJ);
                $tmp = [];
                foreach($position as $pos){
                    $sql = $db->prepare("SELECT *,
                                        ifnull((SELECT menu_name FROM menu WHERE menu.menuID = permission.menuID),permission.menuID)as menu_name,
                                        ifnull((SELECT menu_group FROM menu WHERE menu.menuID = permission.menuID),permission.menuID)as menu_group 
                                        FROM permission 
                                        WHERE positionID = :position_id;");
                    $sql->bindParam(':position_id',$pos->positionID);
                    $sql->execute();
                    $permission = $sql->fetchAll(PDO::FETCH_OBJ);
                    array_push($tmp,['position_id'=>$pos->positionID,'position_name'=>$pos->position_name,'permission'=>$permission]);
                }
            }
               return ['data' =>$tb_user,'require' => true , 'token' => $token,'permission'=> $tmp ];
        } catch (PDOException $e) {
            $db = null;
            return [ 'data' => [], 'require' => false];
        }
    }
    
    public function updateUserByCitizenID($data)
    {
        try {

            // Get DB Object
            $db = new db();
            // connect to DB
            $db = $db->connect();
            // query
            $password = md5($data['password']);
            //echo $password;
            $sql = $db->prepare("INSERT INTO tb_user (`personalID`,`username`,`password`) VALUES (:personalID,:username,:pass)");
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
            $sql = $db->prepare("DELETE FROM tb_user WHERE personalID = :pid; ");
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