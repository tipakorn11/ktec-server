<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
require './src/controllers/news.controller.php';
$app->post('/news/generateNewsLastCode', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $news = new NewsController();
    echo json_encode($news->generateNewsLastCode($data));
});
$app->post('/news/getNewsBy', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $news = new NewsController();
    echo json_encode($news->getNewsBy($data));
});
$app->post('/news/getNewsByid', function (Request $request, Response $response) {
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
    echo json_encode($news->updateNews($data));
});
$app->post('/news/deleteNewsByid', function (Request $request,Response $response) {
    $data = $request->getParsedBody();
    $news = new NewsController();
    echo json_encode($news->deleteNewsByid($data));
});
$app->post('/news/insertFilesDir', function (Request $request,Response $response) {
    $data = $request->getParsedBody();
    $directory = $this->get('upload_directory');
    if (!is_dir($directory . '' . $data['newsID'])) {
        mkdir($directory . '' . $data['newsID']);
    }
    $check = true;
    $db = new db();
    $db = $db->connect();
    if (isset($_FILES)) {
            try {
                move_uploaded_file($_FILES["news_file"]["tmp_name"], 'src/uploads/' . $data['newsID'] . '/' . $_FILES["news_file"]["name"]);
                rename('src/uploads/' . $data['newsID'] . '/' . $_FILES["news_file"]["name"], 'src/uploads/' . $data['newsID'] . '/' . 'news.pdf');
                $file_name_upload = "news.pdf";
                $sql = $db->prepare("UPDATE news SET news_file = :news_file WHERE newsID = :nid;");
                $sql->bindParam(':nid', $data['newsID']);
                $sql->bindParam(':news_file', $file_name_upload);

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
$app->post('/news/downloadFile', function (Request $request, Response $response) {
    $data = $request->getParsedBody();

    $directory = $this->get('upload_directory');
    $directory .= $data['newsID'] . '/news.pdf';
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