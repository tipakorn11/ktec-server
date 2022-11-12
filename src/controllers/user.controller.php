<?php
require './src/models/user.model.php';

class UserController {
    public function getUserBy($data){
        $user = new UserModel();
        return $user->getUserBy($data);
    }

    public function getUserByID($data){
        $user = new BuildingModel();
        return $user->getUserByID($data);
    }

    public function insertUser($data){
        $user = new BuildingModel();
        return $user->insertUser($data);
    }

    public function updateUserByID($data){
        $user = new BuildingModel();
        return $user->updateUserByID($data);
    }

    public function deleteUserByID($data){
        $user = new BuildingModel();
        return $user->deleteUserByID($data);
    }
}