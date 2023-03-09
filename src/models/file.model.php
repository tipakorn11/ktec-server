<?php
class FileModel
{
    //แสดงผู้ใช้
    public function getFileBy()
    {
        try {
            // Get DB Object
            $db = new db();
            // connect to DB
            $db = $db->connect();
            // query
            $sql = "SELECT * FROM File WHERE TRUE";
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
    public function getFileByid($data)
    {
        try {
            // Get DB Object
            $db = new db();
            // connect to DB
            $db = $db->connect();
            // query
            $sql = $db -> prepare("SELECT * FROM File WHERE fileID = :fileid");
            $sql->bindParam(':fileid',$data['fileID']);
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

    public function insertFile($data)
    {
        try {

            $db = new db();
            $db = $db->connect();
            $sql = $db->prepare("INSERT INTO file (`fileID`,`file_title`,`file_description`,`file_file`,`file_file_date`) VALUES (:fileid,:filetitle,:filedescription,:filefile,:filedate)");
            $sql->bindParam(':fileid', $data['fileID']);
            $sql->bindParam(':filetitle', $data['file_title']);
            $sql->bindParam(':filedescription', $data['file_description']);
            $sql->bindParam(':filefile', $data['file_file']);
            $sql->bindParam(':filedate', $data['file_file_date']);
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
    public function updateFile($data)
    {
        try {

            $db = new db();
            $db = $db->connect();
            $sql = $db->prepare("UPDATE file 
                                SET file_title = :filetitle , 
                                    file_description = :filedescription ,
                                    file_file = :filefile
                                WHERE fileID = :fileid; ");
            $sql->bindParam(':fileid', $data['fileID']);
            $sql->bindParam(':filetitle', $data['file_title']);
            $sql->bindParam(':filedescription', $data['file_description']);
            $sql->bindParam(':filefile', $data['file_file']);
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
    public function deleteFileByid($data)
    {
        try {
            $db = new db();
            $db = $db->connect();
            $sql = $db->prepare("DELETE FROM file WHERE fileID = :fileid; ");
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
