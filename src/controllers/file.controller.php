<?php
require './src/models/file.model.php';

class FileController {
    public function getFileBy($data){
        $file_model = new FileModel();
        return $file_model->getFileBy($data);
    }
    public function getFileByid($data){
        $file_model = new FileModel();
        return $file_model->getFileByid($data);
    }
    
    public function insertFile($data)
    {
        $file_model = new FileModel();
        return $file_model->insertFile($data);

     
    }
    public function updateFile($data)
    {
        $file_model = new FileModel();
        return $file_model->updateFile($data);
    }
    public function deleteFileByid($data)
    {
        $file_model = new FileModel();
        return $file_model->deleteFileByid($data);
    }
 
}