<?php
require './src/models/files.model.php';

class FilesController {
    public function generateFileLastCode($data){
        $files_model = new FilesModel();
        $data = ['code'=>'F'.date("Y"),'digit'=>2];
        return $files_model->generateFileLastCode($data);
    }
    public function getFilesBy($data){
        $files_model = new FilesModel();
        return $files_model->getFilesBy($data);
    }
    public function getFilesByid($data){
        $files_model = new FilesModel();
        return $files_model->getFilesByid($data);
    }
    
    public function insertFiles($data)
    {
        $files_model = new FilesModel();
        return $files_model->insertFiles($data);

     
    }
    public function updateFiles($data)
    {
        $files_model = new FilesModel();
        return $files_model->updateFiles($data);
    }
    public function updateStatusFiles($data)
    {
        $files_model = new FilesModel();
        return $files_model->updateStatusFiles($data);
    }
    public function deleteFilesByid($data)
    {
        $files_model = new FilesModel();
        return $files_model->deleteFilesByid($data);
    }
 
}