<?php
require './src/models/prefix.model.php';

class PrefixController {
    public function getPrefixBy($data){
        $prefix_model = new PrefixModel();
        return $prefix_model->getPrefixBy($data);
    }
    public function getPrefixByid($data){
        $prefix_model = new PrefixModel();
        return $prefix_model->getPrefixByid($data);
    }
    public function insertPrefix($data){
        $prefix_model = new PrefixModel();
        return $prefix_model->insertPrefix($data);
    }
    public function updatePrefix($data){
        $prefix_model = new PrefixModel();
        return $prefix_model->updatePrefix($data);
    }
    public function deletePrefixByid($data){
        $prefix_model = new PrefixModel();
        return $prefix_model->deletePrefixByid($data);
    }
   
 
}