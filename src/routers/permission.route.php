<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
require './src/controllers/permission.controller.php';

$app->post('/permission/getPermissionBy', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $permission = new PermissionController();
    echo json_encode($permission->getPermissionBy($data));
});
$app->post('/permission/getPermissionByid', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $permission = new PermissionController();
    echo json_encode($permission->getPermissionByid($data));
});
$app->post('/permission/insertPermission', function (Request $request,Response $response) {
    $data = $request->getParsedBody();
    $permission = new PermissionController();
    echo json_encode($permission->insertPermission($data));
});
$app->post('/permission/updatePermission', function (Request $request,Response $response) {
    $data = $request->getParsedBody();
    $permission = new PermissionController();
    echo json_encode($permission->updatePermission($data));
});
?>