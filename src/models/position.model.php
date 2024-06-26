<?php
class PositionModel
{
    
    public function generatePositionLastCode($data)
    {
        try {
            $db = new db();
            $db = $db->connect();
            $sql = "SELECT CONCAT('".$data['code']."', LPAD(IFNULL(MAX(CAST(SUBSTRING(positionID,'".(strlen($data['code'])+1)."','".$data['digit']."') AS SIGNED)),0) + 1,'".$data['digit']."',0)) AS last_code FROM position WHERE positionID LIKE '".$data['code']."%'";
            $query = $db->query($sql);
            $result = $query->fetchObject();
            $db = null;
            
            if (!$result) {
                return ['data'=>[],'require'=>false];
            } else {
                return ['data' => $result,'require'=>true];
            }
        } catch (PDOException $e) {
            // show error message as Json format
            return ['data'=>[],'require'=>false];
            $db = null;
        }
    }

    public function getPositionBy()
    {
        try {
            // Get DB Object
            $db = new db();
            // connect to DB
            $db = $db->connect();
            // query
            $sql = "SELECT * FROM position WHERE TRUE";
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
    public function getPositionByid($data)
    {
        try {
            $db = new db();
            $db = $db->connect();
            $sql = $db -> prepare("SELECT * FROM position WHERE positionID = :pid");
            $sql->bindParam(':pid',$data['positionID']);
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
    
    public function insertPosition($data)
    {
        try {

            $db = new db();
            $db = $db->connect();
            $sql = $db->prepare("INSERT INTO position (`positionID`,`position_name`) VALUES (:pid,:pname)");
            $sql->bindParam(':pid', $data['positionID']);
            $sql->bindParam(':pname', $data['position_name']);
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
    public function updatePosition($data)
    {
        try {

            $db = new db();
            $db = $db->connect();
            $sql = $db->prepare("UPDATE position 
                                SET position_name = :pname 
                                WHERE positionID = :pid ; ");
            $sql->bindParam(':pid', $data['positionID']);
            $sql->bindParam(':pname', $data['position_name']);
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
    public function deletePositionByid($data)
    {
        try {
            $db = new db();
            $db = $db->connect();

            $permission = $db->prepare("DELETE FROM permission WHERE positionID = :pid; ");
            $permission->bindParam(':pid', $data['positionID']);
            $permission->execute();

            $sql = $db->prepare("DELETE FROM position WHERE positionID = :pid; ");
            $sql->bindParam(':pid', $data['positionID']);
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