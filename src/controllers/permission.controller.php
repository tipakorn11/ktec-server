<?php
require './src/models/permission.model.php';

class PermissionController {
    public function getPermissionBy($data){
        $permission_model = new PermissionModel();
        return $permission_model->getPermissionBy($data);
    }
    public function getPermissionByid($data){
        $permission_model = new PermissionModel();
        return $permission_model->getPermissionByid($data);
    }
    public function insertPermission($data)
    {
        $permission_model = new PermissionModel();
        return $permission_model->insertPermission($data);
     
    }
    public function updatePermission($data)
    {
        $permission_model = new PermissionModel();
        return $permission_model->updatePermission($data);
    }
    
}
?>