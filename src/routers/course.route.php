<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
require './src/controllers/course.controller.php';
$app->post('/course/getCourseBy', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $course = new CourseController();
    echo json_encode($course->getCourseBy($data));
});
$app->post('/course/getCourseByid', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $course = new CourseController();
    echo json_encode($course->getCourseByid($data));
});

$app->post('/course/insertCourse', function (Request $request,Response $response) {
    $data = $request->getParsedBody();
    $course = new CourseController();
    echo json_encode($course->insertCourse($data));
});
$app->post('/course/updateCourse', function (Request $request,Response $response) {
    $data = $request->getParsedBody();
    $course = new CourseController();
    echo json_encode($course->updateCourse($data));
});
$app->post('/course/deleteCourseByid', function (Request $request,Response $response) {
    $data = $request->getParsedBody();
    $course = new CourseController();
    echo json_encode($course->deleteCourseByid($data));
});
