<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
require './src/controllers/position.controller.php';
$app->post('/position/getPositionBy', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $position = new PositionController();
    echo json_encode($position->getPositionBy($data));
});
$app->post('/position/getPositionByid', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $position = new PositionController();
    echo json_encode($position->getPositionByid($data));
});

$app->post('/position/insertPosition', function (Request $request,Response $response) {
    $data = $request->getParsedBody();
    $position = new PositionController();
    echo json_encode($position->insertPosition($data));
});
$app->post('/position/updatePosition', function (Request $request,Response $response) {
    $data = $request->getParsedBody();
    $position = new PositionController();
    echo json_encode($position->updatePosition($data));
});
$app->post('/position/deletePositionByid', function (Request $request,Response $response) {
    $data = $request->getParsedBody();
    $position = new PositionController();
    echo json_encode($position->deletePositionByid($data));
});