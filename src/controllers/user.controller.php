<?php
require './src/models/user.model.php';

class UserController {
    public function getUserBy($data){
        $user_model = new UserModel();
        return $user_model->getUserBy($data);
    }
    
    public function auth($data){
        $user_model = new UserModel();
        return $user_model->auth($data);
    }

    public function checkLogin($data)
    {
        $user_model = new UserModel();
        $user = $user_model->checkLogin($data);
        if($user['require']){
            return $user;
        }else{
            return $user;   
        }
    }
    public function insertUser($data)
    {
        $user_model = new UserModel();
        return $user_model->insertUser($data);
    }
    // public function getUserByID($data){
    //     $user = new BuildingModel();
    //     return $user->getUserByID($data);
    // }

    // public function insertUser($data){
    //     $user = new BuildingModel();
    //     return $user->insertUser($data);
    // }

    // public function updateUserByID($data){
    //     $user = new BuildingModel();
    //     return $user->updateUserByID($data);
    // }

    // public function deleteUserByID($data){
    //     $user = new BuildingModel();
    //     return $user->deleteUserByID($data);
    // }
}