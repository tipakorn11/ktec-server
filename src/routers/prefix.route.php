<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
require './src/controllers/prefix.controller.php';
$app->post('/prefix/getPrefixBy', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $prefix = new PrefixController();
    echo json_encode($prefix->getPrefixBy($data));
});
$app->post('/prefix/getPrefixByid', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $prefix = new PrefixController();
    echo json_encode($prefix->getPrefixByid($data));
});

$app->post('/prefix/insertPrefix', function (Request $request,Response $response) {
    $data = $request->getParsedBody();
    $prefix = new PrefixController();
    echo json_encode($prefix->insertPrefix($data));
});
$app->post('/prefix/updatePrefix', function (Request $request,Response $response) {
    $data = $request->getParsedBody();
    $prefix = new PrefixController();
    echo json_encode($prefix->updatePrefix($data));
});
$app->post('/prefix/deletePrefixByid', function (Request $request,Response $response) {
    $data = $request->getParsedBody();
    $prefix = new PrefixController();
    echo json_encode($prefix->deletePrefixByid($data));
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