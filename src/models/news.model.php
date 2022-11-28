<?php
class NewsModel
{
    //แสดงผู้ใช้
    public function getNewsBy($data)
    {
        try {
            // Get DB Object
            $db = new db();
            // connect to DB
            $db = $db->connect();
            // query
            $sql = "SELECT * FROM News WHERE TRUE";
            $query = $db->query($sql);
            $result = $query->fetchAll(PDO::FETCH_OBJ);
            $count = count($result);
            echo $data;
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

    public function insertNews($data)
    {
        try {

            $db = new db();
            $db = $db->connect();
            $sql = $db->prepare("INSERT INTO news (`newsID`,`news_title`,`news_description`,`news_file`,`news_date`,) 
                                VALUES (:newsID,:news_title,:news_description,:news_file,:news_date)");
            $sql->bindParam(':newsid', $data['newsID']);
            $sql->bindParam(':news_title', $data['news_title']);
            $sql->bindParam(':news_description', $data['news_description']);
            $sql->bindParam(':news_file', $data['news_file']);
            $sql->bindParam(':news_date', $date);

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
    public function updateNews($data)
    {
        try {

            $db = new db();
            $db = $db->connect();
            $sql = $db->prepare("UPDATE news 
                                SET news_title = :news_title , 
                                    news_description = :news_description 
                                    news_file = :news_file
                                WHERE newsid = :newsid; ");
            $sql->bindParam(':newsid', $data['newsID']);
            $sql->bindParam(':news_title', $data['news_title']);
            $sql->bindParam(':news_description', $data['news_description']);
            $sql->bindParam(':news_file', $data['news_file']);
            $sql->bindParam(':news_date', $date);

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
    public function deleteNewsByid($data)
    {
        try {
            $db = new db();
            $db = $db->connect();
            $sql = $db->prepare("DELETE FROM news WHERE newsID = :newsid; ");
            $sql->bindParam(':newsid', $data['newsID']);
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
