<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
require './src/controllers/files.controller.php';
$app->post('/files/generateFileLastCode', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $files = new FilesController();
    echo json_encode($files->generateFileLastCode($data));
});
$app->post('/files/getFilesBy', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $files = new FilesController();
    echo json_encode($files->getFilesBy($data));
});
$app->post('/files/getFilesByid', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $files = new FilesController();
    echo json_encode($files->getFilesByid($data));
});
$app->post('/files/insertFiles', function (Request $request,Response $response) {
    $data = $request->getParsedBody();
    $files = new FilesController();
    echo json_encode($files->insertFiles($data));
});

$app->post('/files/insertFilesDir', function (Request $request,Response $response) {
    $data = $request->getParsedBody();
    $directory = $this->get('upload_directory');
    if (!is_dir($directory . '' . $data['fileID'])) {
        mkdir($directory . '' . $data['fileID']);
    }
    $check = true;
    $db = new db();
    $db = $db->connect();
    if (isset($_FILES)) {
            try {
                move_uploaded_file($_FILES["file_pdf"]["tmp_name"], 'src/uploads/' . $data['fileID'] . '/' . $_FILES["file_pdf"]["name"]);
                rename('src/uploads/' . $data['fileID'] . '/' . $_FILES["file_pdf"]["name"], 'src/uploads/' . $data['fileID'] . '/' . 'news.pdf');
                $file_name_upload = "news.pdf";
                $sql = $db->prepare("UPDATE tb_file SET file_pdf = :file_pdf WHERE fileID = :fid;");
                $sql->bindParam(':fid', $data['fileID']);
                $sql->bindParam(':file_pdf', $file_name_upload);

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
$app->post('/files/downloadFile', function (Request $request, Response $response) {
    $data = $request->getParsedBody();

    $directory = $this->get('upload_directory');
    $directory .= $data['fileID'] . '/news.pdf';
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