<?php
class UserModel
{
    //แสดงข้อมูลอาคาร
    public function getUserBy($data)
    {
        try {
            // Get DB Object
            $db = new db();
            // connect to DB
            $db = $db->connect();
            // query
            $sql = "SELECT * FROM User WHERE TRUE";
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

            if(isset($data['params']['pagination'])){
                $sql .= " LIMIT ".($data['params']['pagination']['current']* $data['params']['pagination']['pageSize'] - $data['params']['pagination']['pageSize']).",".($data['params']['pagination']['pageSize'])."";
            }
            $query = $db->query($sql);
            $result = $query->fetchAll(PDO::FETCH_OBJ);
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
    //แสดงข้อมูลอาคารเฉพาะอาคารที่ต้องการ
    public function getBuildingByID($data){
        try {
            // Get DB Object
            $db = new db();
            // connect to DB
            $db = $db->connect();
            // query
            $sql = $db->prepare("SELECT * FROM building WHERE building_id = :building_id");
            $sql->bindParam(':building_id',$data['building_id']);
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
            return ['data' => [], 'require' => false];
        }
    }
    //เพิ่มข้อมูลอาคาร
    public function insertBuilding($data){
        try {
            // Get DB Object
            $db = new db();
            // connect to DB
            $db = $db->connect();
            // query
            $sql = $db->prepare("INSERT INTO building (`building_id`,`building_name`) VALUES (:building_id,:building_name)");
            $sql->bindParam(':building_id',$data['building_id']);
            $sql->bindParam(':building_name',$data['building_name']);
            $sql->execute();
            $db = null;
            if (!$sql) {
                return ['data' => [], 'require' => false];
            } else {
                return ['data' => [], 'require' => true];
            }
        } catch (PDOException $e) {
            $db = null;
            return ['data' => [], 'require' => false];
        }
    }
    //แก้ไขข้อมูลอาคาร
    public function updateBuilding($data){
        try {
            // Get DB Object
            $db = new db();
            // connect to DB
            $db = $db->connect();
            // query
            $sql = $db->prepare("UPDATE building SET building_name=:building_name WHERE building_id=:building_id");
            $sql->bindParam(':building_id',$data['building_id']);
            $sql->bindParam(':building_name',$data['building_name']);
            $sql->execute();
            $db = null;
            if (!$sql) {
                return ['data' => [], 'require' => false];
            } else {
                return ['data' => [], 'require' => true];
            }
        } catch (PDOException $e) {
            $db = null;
            return ['data' => [], 'require' => false];
        }
    }
    //ลบข้อมูลอาคาร
    public function deleteBuilding($data){
        try {
            // Get DB Object
            $db = new db();
            // connect to DB
            $db = $db->connect();
            // query
            $sql = $db->prepare("DELETE FROM building WHERE building_id = :building_id");
            $sql->bindParam(':building_id',$data['building_id']);
            $sql->execute();
            $db = null;
            if (!$sql) {
                return ['data' => [], 'require' => false];
            } else {
                return ['data' => [], 'require' => true];
            }
        } catch (PDOException $e) {
            $db = null;
            return ['data' => [], 'require' => false];
        }
    }
}
