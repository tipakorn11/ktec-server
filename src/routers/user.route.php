<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
require './src/controllers/user.controller.php';
$app->post('/user/getUserBy', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $user = new userController();
    echo json_encode($user->getUserBy($data));
});
$app->post('/user/getUserByUsername', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $user = new userController();
    echo json_encode($user->getUserByUsername($data));
});
$app->post('/user/getUserCitizenid', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $user = new userController();
    echo json_encode($user->getUserCitizenid($data));
});
$app->post('/user/generateUserLastCode', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $user = new userController();
    echo json_encode($user->generateUserLastCode($data));
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


$app->post('/user/updateUserByid', function(Request $request, Response $response){
    $data = $request->getParsedBody();
    $user = new UserController();
    echo json_encode($user->updateUserByid($data));
});
$app->post('/user/insertUser', function(Request $request, Response $response){
    $data = $request->getParsedBody();
    $user = new UserController();
    echo json_encode($user->insertUser($data));
});
$app->post('/user/updateUserByCitizenid', function(Request $request, Response $response){
    $data = $request->getParsedBody();
    $user = new UserController();
    echo json_encode($user->updateUserByCitizenid($data));
});

$app->post('/user/deleteUserByid',function(Request $request,Response $response){
    $data = $request->getParsedBody();
    $user = new UserController();
    echo json_encode($user->deleteUserByid($data));
});