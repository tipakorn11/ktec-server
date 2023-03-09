<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
require './src/controllers/file.controller.php';
$app->post('/file/getFileBy', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $file = new FileController();
    echo json_encode($file->getFileBy($data));
});
$app->post('/file/getFileByid', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $file = new FileController();
    echo json_encode($file->getFileByid($data));
});
$app->post('/file/insertFile', function (Request $request,Response $response) {
    $data = $request->getParsedBody();
    $file = new FileController();
    echo json_encode($file->insertFile($data));
});
$app->post('/file/updateFile', function (Request $request,Response $response) {
    $data = $request->getParsedBody();
    $file = new FileController();
    echo json_encode($file->updateFile($data));
});
$app->post('/file/deleteFileByid', function (Request $request,Response $response) {
    $data = $request->getParsedBody();
    $file = new FileController();
    echo json_encode($file->deleteFileByid($data));
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