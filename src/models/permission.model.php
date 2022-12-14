<?php
class PermissionModel
{
    //แสดงผู้ใช้
    public function getPermissionBy()
    {
        try {
            // Get DB Object
            $db = new db();
            // connect to DB
            $db = $db->connect();
            // query
            $sql = "SELECT * FROM permission WHERE TRUE";
            $query = $db->query($sql);
            $result = $query->fetchAll(PDO::FETCH_OBJ);
            $count = count($result);
            $db = null;
            if (!$result) {
                return ['data' => [], 'require' => false];
            } else {
                return ['data' => $result, 'require' => true, 'total' => $count];
            }
        } catch (PDOException $e) {
            $db = null;
            return ['data' => [], 'require' => false];
        }
        
    }
    public function getPermissionByid($data)
    {
        try {
            $db = new db();
            $db = $db->connect();
            $sql = $db -> prepare("SELECT *,
                                    ifnull((SELECT position.position_name FROM position WHERE user_position.positionID = position.positionID ),positionID ) as position_name 
                                    FROM user_position 
                                    WHERE personalID = :pid ;
            ");
            $sql->bindParam(':pid',$data['personalID']);
            $sql->execute();
            $result = $sql->fetchAll(PDO::FETCH_OBJ);
            
            $db = null;
            if (!$result) {
                return ['data' => [], 'require' => false];
            } else {
                return ['data' => $result, 'require' => true];
            }
        } catch (PDOException $e) {
            $db = null;
            return ['data' => 'catch', 'require' => false];
        }
    }
    
    public function insertPermission($data)
    {
        try {

            $db = new db();
            $db = $db->connect();
            $sql = $db->prepare("INSERT INTO permission (`permissionID`,`permission_name`) VALUES (:pid,:pname)");
            $sql->bindParam(':pid', $data['permissionID']);
            $sql->bindParam(':pname', $data['permission_name']);
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
    public function updatePermission($data)
    {
        try {

            $db = new db();
            $db = $db->connect();
            $sql = $db->prepare("UPDATE permission 
                                SET permission_name = :pname 
                                WHERE permissionID = :pid ; ");
            $sql->bindParam(':pid', $data['permissionID']);
            $sql->bindParam(':pname', $data['permission_name']);
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
    public function deletePermissionByid($data)
    {
        try {
            $db = new db();
            $db = $db->connect();
            $sql = $db->prepare("DELETE FROM permission WHERE permissionID = :pid; ");
            $sql->bindParam(':pid', $data['permissionID']);
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
