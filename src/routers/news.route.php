<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
require './src/controllers/news.controller.php';
$app->post('/news/getNewsBy', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $news = new NewsController();
    echo json_encode($news->getNewsBy($data));
});
$app->post('/news/getNewsByid', function (Request $request,Response $response) {
    $data = $request->getParsedBody();
    $news = new NewsController();
    echo json_encode($news->getNewsByid($data));
});
$app->post('/news/insertNews', function (Request $request,Response $response) {
    $data = $request->getParsedBody();
    $news = new NewsController();
    echo json_encode($news->insertNews($data));
});
$app->post('/news/updateNews', function (Request $request,Response $response) {
    $data = $request->getParsedBody();
    $news = new NewsController();
    echo json_encode($news->insertNews($data));
});
$app->post('/news/deleteNewsByid', function (Request $request,Response $response) {
    $data = $request->getParsedBody();
    $news = new NewsController();
    echo json_encode($news->deleteNewsByid($data));
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