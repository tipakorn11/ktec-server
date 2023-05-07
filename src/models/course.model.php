<?php
class CourseModel
{

    public function generateCourseLastCode($data)
    {
        try {
            $db = new db();
            $db = $db->connect();
            $sql = "SELECT CONCAT('" . $data['code'] . "', LPAD(IFNULL(MAX(CAST(SUBSTRING(courseID,'" . (strlen($data['code']) + 1) . "','" . $data['digit'] . "') AS SIGNED)),0) + 1,'" . $data['digit'] . "',0)) AS last_code FROM course WHERE courseID LIKE '" . $data['code'] . "%'";
            $query = $db->query($sql);
            $result = $query->fetchObject();
            $db = null;

            if (!$result) {
                return ['data' => [], 'require' => false];
            } else {
                return ['data' => $result, 'require' => true];
            }
        } catch (PDOException $e) {
            // show error message as Json format
            return ['data' => [], 'require' => false];
            $db = null;
        }
    }

    public function getCourseBy()
    {
        try {
            // Get DB Object
            $db = new db();
            // connect to DB
            $db = $db->connect();
            // query
            $sql = "SELECT * FROM course WHERE TRUE";
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
    public function getCourseByid($data)
    {
        try {
            $db = new db();
            $db = $db->connect();
            $sql = $db->prepare("SELECT * FROM course WHERE courseID = :cid");
            $sql->bindParam(':cid', $data['courseID']);
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

    public function insertCourse($data)
    {
        try {

            $db = new db();
            $db = $db->connect();
            $sql = $db->prepare("INSERT INTO course (`courseID`,`course_name`) VALUES (:cid,:cname)");
            $sql->bindParam(':cid', $data['courseID']);
            $sql->bindParam(':cname', $data['course_name']);
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
    public function updateCourse($data)
    {
        try {

            $db = new db();
            $db = $db->connect();
            $sql = $db->prepare("UPDATE course 
                                SET course_name = :cname 
                                WHERE courseID = :cid ; ");
            $sql->bindParam(':cid', $data['courseID']);
            $sql->bindParam(':cname', $data['course_name']);
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
    public function deleteCourseByid($data)
    {
        try {
            $db = new db();
            $db = $db->connect();
            $sql = $db->prepare("DELETE FROM course
                                    WHERE courseID = :cid
                                    AND NOT EXISTS (
                                        SELECT 1 FROM tb_user WHERE courseID = :cid); ");
            $sql->bindParam(':cid', $data['courseID']);
            $sql->execute();

            $sql = $db->prepare("SELECT 1 FROM tb_user WHERE courseID = :cid; ");
            $sql->bindParam(':cid', $data['courseID']);
            $sql->execute();
            $result = $sql->fetchAll(PDO::FETCH_OBJ);
            $db = null;
            if (!$sql) {
                return ['data' => [],'require' => false];
            } else {
                return ['data' => $result,'require' => true];
            }
        } catch (PDOException $e) {
            $db = null;
            echo $e->getMessage();
            return ['require' => false];
        }
    }
}
