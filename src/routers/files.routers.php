<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
require './src/controllers/files.controller.php';
$app->post('/files/getFilesBy', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $files = new FilesController();
    echo json_encode($files->getFilesBy($data));
});
$app->post('/files/getFilesPersonalByid', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $files = new FilesController();
    echo json_encode($files->getFilesByid($data));
});
$app->post('/files/insertFiles', function (Request $request,Response $response) {
    $data = $request->getParsedBody();
    $files = new FilesController();
    echo json_encode($files->insertFiles($data));
});
$app->post('/files/updateFiles', function (Request $request,Response $response) {
    $data = $request->getParsedBody();
    $files = new FilesController();
    echo json_encode($files->updateFiles($data));
});
$app->post('/files/updateStatusFiles', function (Request $request,Response $response) {
    $data = $request->getParsedBody();
    $files = new FilesController();
    echo json_encode($files->updateStatusFiles($data));
});
$app->post('/files/deleteFilesByid', function (Request $request,Response $response) {
    $data = $request->getParsedBody();
    $files = new FilesController();
    echo json_encode($files->deleteFilesByid($data));
});

?>