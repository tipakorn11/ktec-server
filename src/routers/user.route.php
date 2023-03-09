<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
require './src/controllers/user.controller.php';
$app->post('/user/getUserBy', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $user = new userController();
    echo json_encode($user->getUserBy($data));
});

$app->post('/user/getUserByid', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $user = new userController();
    echo json_encode($user->getUserByid($data));
});
$app->post('/user/auth', function (Request $request, Response $response) {
    $token = $request->getHeaderLine('x-access-token');
    // pass token 
    $data = $request->getParsedBody();
    $user = new userController();
    echo json_encode($user->auth($token));
});

$app->post('/user/checkLogin', function (Request $request, Slim\Http\Response $response) {
    $data = $request->getParsedBody();
    $user = new UserController();
    echo json_encode($user->checkLogin($data));
});


$app->post('/building/updateuserByid', function(Request $request, Response $response){
    $data = $request->getParsedBody();
    $user = new UserController();
    echo json_encode($user->updateuserByid($data));
});

$app->post('/building/deleteuserByID',function(Request $request,Response $response){
    $data = $request->getParsedBody();
    $user = new UserController();
    echo json_encode($user->deleteuserByID($data));
});
?>