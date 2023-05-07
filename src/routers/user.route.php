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
$app->post('/user/insertImgDir', function (Request $request,Response $response) {
    $data = $request->getParsedBody();
    $check = true;
    $db = new db();
    $db = $db->connect();
    $img_name = base64_encode($data['img']);
    if (isset($_FILES)) {
        try {
            $sql = $db->prepare("UPDATE tb_user SET img = :img WHERE personalID = :nid;");
            $sql->bindParam(':nid', $data['personalID']);
            $sql->bindParam(':img', $img_name);
            $sql->execute();
        } catch (Exception $e) {
            $check = false;
            echo  $e ;
        }
        $db = null;
        if ($check) {
            echo json_encode(['data' => [], 'require' => true]);
        } else {
            echo json_encode(['data' => [], 'require' => false]);
        }
    }
});
$app->post('/user/downloadFile', function (Request $request, Response $response) {
    $data = $request->getParsedBody();

    $directory = $this->get('upload_directory');
    $directory .= $data['personalID'] . '/img.jpg';
    $response->withHeader('Content-Type', 'application/force-download')
        ->withHeader('Content-Type', 'application/octet-stream')
        ->withHeader('Content-Type', 'application/download')
        ->withHeader('Content-Description', 'File Transfer')
        ->withHeader('Content-Transfer-Encoding', 'binary')
        ->withHeader('Content-Disposition', 'attachment; filename="' . basename($directory) . '"')
        ->withHeader('Expires', '0')
        ->withHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
        ->withHeader('Pragma', 'public');

    readfile($directory);
    return $response;
    
});