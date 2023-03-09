<?php
require './src/models/education.model.php';

class EducationController {
    public function getEducationBy($data){
        $education_model = new EducationModel();
        return $education_model->getEducationBy($data);
    }
    public function getEducationByid($data){
        $education_model = new EducationModel();
        return $education_model->getEducationByid($data);
    }
    public function insertEducation($data){
        $education_model = new EducationModel();
        return $education_model->insertEducation($data);
    }
    public function updateEducation($data){
        $education_model = new EducationModel();
        return $education_model->updateEducation($data);
    }
    public function deleteEducationByid($data){
        $education_model = new EducationModel();
        return $education_model->deleteEducationByid($data);
    }
   
 
}
?>