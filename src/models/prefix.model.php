<?php
class PrefixModel
{
    //แสดงผู้ใช้
    public function getPrefixBy()
    {
        try {
            // Get DB Object
            $db = new db();
            // connect to DB
            $db = $db->connect();
            // query
            $sql = "SELECT * FROM prefix WHERE TRUE";
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
    public function getPrefixByid($data)
    {
        try {
            $db = new db();
            $db = $db->connect();
            $sql = $db -> prepare("SELECT * FROM prefix WHERE prefixID = :pid");
            $sql->bindParam(':pid',$data['prefixID']);
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
    
    public function insertPrefix($data)
    {
        try {

            $db = new db();
            $db = $db->connect();
            $sql = $db->prepare("INSERT INTO prefix (`prefixID`,`prefix_name`) VALUES (:pid,:pname)");
            $sql->bindParam(':pid', $data['prefixID']);
            $sql->bindParam(':pname', $data['prefix_name']);
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
    public function updatePrefix($data)
    {
        try {

            $db = new db();
            $db = $db->connect();
            $sql = $db->prepare("UPDATE prefix 
                                SET prefix_name = :pname 
                                WHERE prefixID = :pid ; ");
            $sql->bindParam(':pid', $data['prefixID']);
            $sql->bindParam(':pname', $data['prefix_name']);
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
    public function deletePrefixByid($data)
    {
        try {
            $db = new db();
            $db = $db->connect();
            $sql = $db->prepare("DELETE FROM prefix WHERE prefixID = :pid; ");
            $sql->bindParam(':pid', $data['prefixID']);
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