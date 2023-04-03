<?php
class FilesModel
{
    public function generateFileLastCode($data)
    {
        try {
            $db = new db();
            $db = $db->connect();
            $sql = "SELECT CONCAT('".$data['code']."', LPAD(IFNULL(MAX(CAST(SUBSTRING(fileID,'".(strlen($data['code'])+1)."','".$data['digit']."') AS SIGNED)),0) + 1,'".$data['digit']."',0)) AS last_code FROM tb_file WHERE fileID LIKE '".$data['code']."%'";
            $query = $db->query($sql);
            $result = $query->fetchObject();
            $db = null;
            
            if (!$result) {
                return ['data'=>[],'require'=>false];
            } else {
                return ['data' => $result,'require'=>true];
            }
        } catch (PDOException $e) {
            return ['data'=>[],'require'=>false];
            $db = null;
        }
    }
    public function getFilesBy($data)
    {
        try {
            $db = new db();
            $db = $db->connect();
            $condition = "";
            if(isset($data['file_status']) ) $condition .= "AND file_status = "."'".$data['file_status']."'"."";
            if(isset($data['personalID']) ) $condition .= "AND tb_file.personalID = "."'".$data['personalID']."'"."";

            $sql = "SELECT *,
                    IFNULL((SELECT CONCAT(thai_fname,' ',thai_lname) FROM tb_user WHERE tb_user.personalID = tb_file.personalID), '') as fullname ,
                    IFNULL((SELECT position_name FROM position WHERE positionID = (
                                                                                    SELECT positionID 
                                                                                    FROM user_position 
                                                                                    WHERE user_position.personalID = tb_file.personalID
                                                                                    LIMIT 1
                                                                                    )),'') as position_name
                    FROM tb_file 
                    WHERE true ".$condition."
                    ORDER BY tb_file.file_date_upload ASC";
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
            $db = new db();
            $db = $db->connect();
            $sql = $db -> prepare("SELECT *,
                                    IFNULL((SELECT CONCAT(thai_fname, ' ', thai_lname) FROM tb_user WHERE tb_user.personalID = tb_file.personalID), NULL) AS fullname
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
            $sql = $db->prepare("INSERT INTO tb_file (`fileID`,`personalID`,`file_name`,`file_status`,`file_date_upload`,`file_pdf`) 
                                    VALUES (:fileid,:pid,:filesname,:filestatus,NOW(),:filepdf)");
            $sql->bindParam(':fileid', $data['fileID']);
            $sql->bindParam(':pid', $data['personalID']);
            $sql->bindParam(':filesname', $data['file_name']);
            $sql->bindParam(':filestatus', $data['file_status']);
            $sql->bindParam(':filepdf', $data['file_pdf']);

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
            $sql = $db->prepare("UPDATE tb_file 
                                SET file_name = :filesname , 
                                    file_date_upload =  NOW() ,
                                    file_pdf = :filepdf,
                                    file_status = :filestatus
                                WHERE fileID = :fileid; ");
            $sql->bindParam(':fileid', $data['fileID']);
            $sql->bindParam(':filesname', $data['file_name']);
            $sql->bindParam(':filepdf', $data['file_pdf']);
            $sql->bindParam(':filestatus', $data['file_status']);
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
            $sql = $db->prepare("UPDATE tb_file 
                                SET file_status = :filestatus , 
                                    file_note = :filesnote ,
                                    file_date_upload = NOW(),
                                    file_date_handle = NOW()
                                WHERE fileID = :fileid ");
            $sql->bindParam(':fileid', $data['fileID']);
            $sql->bindParam(':filestatus', $data['file_status']);
            $sql->bindParam(':filesnote', $data['file_note']);

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