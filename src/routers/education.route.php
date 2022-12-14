<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
require './src/controllers/education.controller.php';
$app->post('/education/getEducationBy', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $education = new EducationController();
    echo json_encode($education->getEducationBy($data));
});
$app->post('/education/getEducationByid', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $education = new EducationController();
    echo json_encode($education->getEducationByid($data));
});

$app->post('/education/insertEducation', function (Request $request,Response $response) {
    $data = $request->getParsedBody();
    $education = new EducationController();
    echo json_encode($education->insertEducation($data));
});
$app->post('/education/updateEducation', function (Request $request,Response $response) {
    $data = $request->getParsedBody();
    $education = new EducationController();
    echo json_encode($education->updateEducation($data));
});
$app->post('/education/deleteEducationByid', function (Request $request,Response $response) {
    $data = $request->getParsedBody();
    $education = new EducationController();
    echo json_encode($education->deleteEducationByid($data));
});

// $app->post('/user/getUserByID', function (Request $request, Response $response) {
//     $data = $request->getParsedBody();
//     $user = new userController();
//     echo json_encode($building->getUserByID($data));
// });

// $app->post('/building/insertu', function (Request $request, Response $response) {
//     $data = $request->getParsedBody();
//     $building = new BuildingController();
//     echo json_encode($building->insertBuilding($data));
// });

// $app->post('/building/updateuserByID', function(Request $request, Response $response){
//     $data = $request->getParsedBody();
//     $building = new BuildingController();
//     echo json_encode($building->insertBuilding($data));
// });

// $app->post('/building/deleteuserByID',function(Request $request,Response $response){
//     $data = $request->getParsedBody();
//     $building = new BuildingController();
//     echo json_encode($building->insertBuilding($data));
// });