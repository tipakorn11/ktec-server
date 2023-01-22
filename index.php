<?php
// # use Namespaces for HTTP request
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
ini_set('display_errors', false);
// # include the Slim framework
date_default_timezone_set("UTC");
require 'vendor/autoload.php';
require 'src/config/db.php';
use Mpdf\Mpdf;
$app = new \Slim\App;

setlocale(LC_ALL, "th_TH.UTF-8");
$container = $app->getContainer();
$container['upload_directory'] = __DIR__ . '/src/uploads/';
$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization,x-access-token')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

require 'src/routers/education.route.php';
require 'src/routers/permission.route.php';
require 'src/routers/position.route.php';
require 'src/routers/prefix.route.php';
require 'src/routers/course.route.php';
require 'src/routers/news.route.php';
require 'src/routers/user.route.php';
require 'src/JwtHandler.php';


$app->run();
