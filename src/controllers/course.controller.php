<?php
require './src/models/course.model.php';

class CourseController {
    public function generateCourseLastCode($data){
        $course_model = new CourseModel();
        $data = ['code'=>'C'.date("Y"),'digit'=>2];
        return $course_model->generateCourseLastCode($data);
    }
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