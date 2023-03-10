<?php
require './src/models/position.model.php';

class PositionController {
    public function getPositionBy($data){
        $position_model = new PositionModel();
        return $position_model->getPositionBy($data);
    }
    public function getPositionByid($data){
        $position_model = new PositionModel();
        return $position_model->getPositionByid($data);
    }
    public function insertPosition($data){
        $position_model = new PositionModel();
        return $position_model->insertPosition($data);
    }
    public function updatePosition($data){
        $position_model = new PositionModel();
        return $position_model->updatePosition($data);
    }
    public function deletePositionByid($data){
        $position_model = new PositionModel();
        return $position_model->deletePositionByid($data);
    }
   
 
}