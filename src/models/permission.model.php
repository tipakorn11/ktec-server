<?php
class PermissionModel
{
    public function getPermissionBy()
    {
        try {
            $db = new db();
            $db = $db->connect();
           
                $sql = $db->prepare("SELECT tb.menuID,
                menu_group,
                menu_name,
                menu_name_en,
                IFNULL(permission_view, FALSE) AS permission_view,
                IFNULL(permission_add, FALSE) AS permission_add,
                IFNULL(permission_edit, FALSE) AS permission_edit,
                IFNULL(permission_approve, FALSE) AS permission_approve,
                IFNULL(permission_cancel, FALSE) AS permission_cancel,
                IFNULL(permission_delete, FALSE) AS permission_delete
                FROM permission as tb
                LEFT JOIN menu ON menu.menuID = tb.menuID 
                ORDER BY menu_group, tb.menuID;");
                                    
                $sql->execute();
                $permission = $sql->fetchAll(PDO::FETCH_OBJ);
               return ['data'=> $permission ,'require' => true ];
        } catch (PDOException $e) {
            $db = null;
            return [ 'data' => [], 'require' => false];
        }
    }
    public function getPermissionByid($data)
    {
        try {
            $db = new db();
            $db = $db->connect();
           
                $sql = $db->prepare("SELECT   
                                    menu_group,
                                    menu_name,
                                    menu_name_en,
                                    IFNULL(permission_view, FALSE) AS permission_view,
                                    IFNULL(permission_add, FALSE) AS permission_add,
                                    IFNULL(permission_edit, FALSE) AS permission_edit,
                                    IFNULL(permission_approve, FALSE) AS permission_approve,
                                    IFNULL(permission_cancel, FALSE) AS permission_cancel,
                                    IFNULL(permission_delete, FALSE) AS permission_delete
                                    FROM permission as tb
                                    LEFT JOIN menu ON menu.menuID = tb.menuID AND positionID = :position_id || ''");
                $sql->bindParam(':position_id',$data['positionID']);
                $sql->execute();
                $permission = $sql->fetchAll(PDO::FETCH_OBJ);
               return ['permission'=> $permission ,'require' => true ];
        } catch (PDOException $e) {
            $db = null;
            return [ 'data' => [], 'require' => false];
        }
    }
    
    public function insertPermission($data){
        try {
            $db = new db();
            $db = $db->connect();
            foreach($data['permissions'] as $permission){
            $sql = $db->prepare("INSERT INTO permission 
            (`positionID`,`menuID`,`permission_add`,`permission_edit`,`permission_delete`,`permission_view`,`permission_approve`,`permission_cancel`)
            VALUE
            (:position_id , :menuid , :permission_add , :permission_edit , :permission_delete , :permission_view , :permission_approve , :permission_cancel)");
           
           $sql->bindParam(':position_id',$permission['positionID']);
           $sql->bindParam(':menuid',$permission['menuID']);
           $sql->bindParam(':permission_add',$permission['permission_add']);
           $sql->bindParam(':permission_edit',$permission['permission_edit']);
           $sql->bindParam(':permission_delete',$permission['permission_delete']);
           $sql->bindParam(':permission_view',$permission['permission_view']);
           $sql->bindParam(':permission_approve',$permission['permission_approve']);
           $sql->bindParam(':permission_cancel',$permission['permission_cancel']);
           
           $sql->execute();
           
        }
        $db = null;
            if (!$sql) {
                return ['data'=>[],'require'=>false];
            } else {
                return ['data' =>[],'require'=>true];
            }
        } catch (PDOException $e) {
            $db = null;
            return ['data'=>[],'require'=>false];
        }
    }
    public function updatePermission($data){
        try {
            // Get DB Object
            $db = new db();
            // connect to DB
            $db = $db->connect();
            // query
            $sql = $db->prepare("UPDATE permission 
            SET permission_add = :permission_add,
            permission_edit =:permission_edit,
            permission_delete =:permission_delete,
            permission_view =:permission_view
            permission_approve =:permission_approve,
            permission_cancel =:permission_cancel
            WHERE position_id = :position_id AND menu_code =:menu_code;
            ");
            $sql->bindParam(':position_id',$data['position_id']);
            $sql->bindParam(':menu_code',$data['menu_code']);
            $sql->bindParam(':permission_add',$data['permission_add']);
            $sql->bindParam(':permission_edit',$data['permission_edit']);
            $sql->bindParam(':permission_delete',$data['permission_delete']);
            $sql->bindParam(':permission_view',$data['permission_view']);
            $sql->bindParam(':permission_approve',$data['permission_approve']);
            $sql->bindParam(':permission_cancel',$data['permission_cancel']);

            $sql->execute();
            $db = null;
            if (!$sql) {
                return ['data'=>[],'require'=>false];
            } else {
                return ['data' =>[],'require'=>true];
            }
        } catch (PDOException $e) {
            $db = null;
            return ['data'=>[],'require'=>false];
        }
    }
   
}
