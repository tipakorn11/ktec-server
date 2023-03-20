<?php
class FilesModel
{
    //แสดงผู้ใช้
    public function getFilesBy($data)
    {
        try {
            // Get DB Object
            $db = new db();
            // connect to DB
            $db = $db->connect();
            // query
            $condition = "";
            if(isset($data['file_status']) ) $condition .= "AND file_status = "."'".$data['file_status']."'"."";
            if(isset($data['personalID']) ) $condition .= "AND personalID = "."'".$data['personalID']."'"."";

            $sql = "SELECT * FROM tb_file WHERE true ".$condition;
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
    public function getFilesByid($data)
    {
        try {
            // Get DB Object
            $db = new db();
            // connect to DB
            $db = $db->connect();
            // query
            $sql = $db -> prepare("SELECT *,
                            IFNULL((SELECT CONCAT(thai_fname, ' ', thai_lname) 
                            FROM tb_user 
                            WHERE tb_user.personalID = tb_file.personalID), NULL) AS fullname
                            FROM tb_file WHERE fileID = :fid");
            $sql->bindParam(':fid',$data['fileID']);
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

    public function insertFiles($data)
    {
        try {

            $db = new db();
            $db = $db->connect();
            $sql = $db->prepare("INSERT INTO file (`fileID`,`personalID`,`file_name`,`file_status`,`file_date`) VALUES (:fileid,:filetitle,:filesname,:filestatus,:filedate)");
            $sql->bindParam(':fileid', $data['fileID']);
            $sql->bindParam(':pid', $data['personalID']);
            $sql->bindParam(':filesname', $data['file_name']);
            $sql->bindParam(':filestatus', $data['file_status']);
            $sql->bindParam(':filedate', $data['file_date']);
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
    public function updateFiles($data)
    {
        try {

            $db = new db();
            $db = $db->connect();
            $sql = $db->prepare("UPDATE file 
                                SET file_name = :filesname , 
                                    file_date = :filedate ,
                                WHERE fileID = :fileid; ");
            $sql->bindParam(':fileid', $data['fileID']);
            $sql->bindParam(':filesname', $data['file_name']);
            $sql->bindParam(':filedate', $data['file_date']);
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
    public function updateStatusFiles($data)
    {
        try {
            
            $db = new db();
            $db = $db->connect();
            $sql = $db->prepare("UPDATE file 
                                SET file_status = :filestatus , 
                                    file_date = :filedate ,
                                WHERE fileID = :fileid; ");
            $sql->bindParam(':fileid', $data['fileID']);
            $sql->bindParam(':filesname', $data['file_name']);
            $sql->bindParam(':filedate', $data['file_date']);
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
    public function deleteFilesByid($data)
    {
        try {
            $db = new db();
            $db = $db->connect();
            $sql = $db->prepare("DELETE FROM tb_file WHERE fileID = :fileid; ");
            $sql->bindParam(':fileid', $data['fileID']);
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