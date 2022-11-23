<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
require './src/controllers/user.controller.php';
$app->post('/user/getUserBy', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $user = new userController();
    echo json_encode($user->getUserBy($data));
});

$app->post('/user/auth', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $user = new userController();
    echo json_encode($user->auth($data));
});

$app->post('/user/checkLogin', function (Request $request, Slim\Http\Response $response) {
    $data = $request->getParsedBody();
    $user = new UserController();
    echo json_encode($user->checkLogin($data));
});
$app->post('/user/insertUser', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $user = new UserController();
    echo json_encode($user->insertUser($data));
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