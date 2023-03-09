<?php
require './src/models/course.model.php';

class CourseController {
    public function getCourseBy($data){
        $course_model = new CourseModel();
        return $course_model->getCourseBy($data);
    }
    public function getCourseByid($data){
        $course_model = new CourseModel();
        return $course_model->getCourseByid($data);
    }
    public function insertCourse($data){
        $course_model = new CourseModel();
        return $course_model->insertCourse($data);
    }
    public function updateCourse($data){
        $course_model = new CourseModel();
        return $course_model->updateCourse($data);
    }
    public function deleteCourseByid($data){
        $course_model = new CourseModel();
        return $course_model->deleteCourseByid($data);
    }
   
 
}
?>