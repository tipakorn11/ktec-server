<?php
require './src/models/user.model.php';

class UserController {
    public function generateUserLastCode($data){
        $user_model = new UserModel();
        $data = ['code'=>'ktec'.date("Y"),'digit'=>2];
        return $user_model->generateUserLastCode($data);
    }
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
    public function getUserByid($data){
        $user_model = new UserModel();
        return $user_model->getUserByid($data);
    }
   
    public function updateUserByid($data){
        $user = new UserModel();
        return $user->updateUserByid($data);
    }
    
    public function updateUserByCitizenid($data){
        $user = new UserModel();
        return $user->updateUserByCitizenid($data);
    }
    public function insertUser($data){
        $user = new UserModel();
        return $user->insertUser($data);
    }
    public function deleteUserByid($data){
        $user = new UserModel();
        return $user->deleteUserByid($data);
    }
}