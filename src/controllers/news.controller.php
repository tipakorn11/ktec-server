<?php
require './src/models/news.model.php';

class NewsController {
    public function getNewsBy($data){
        $news_model = new NewsModel();
        return $news_model->getNewsBy($data);
    }
    public function getNewsByid($data){
        $news_model = new NewsModel();
        return $news_model->getNewsByid($data);
    }
    
    public function insertNews($data)
    {
        $news_model = new NewsModel();
        return $news_model->insertNews($data);

     
    }
    public function updateNews($data)
    {
        $news_model = new NewsModel();
        return $news_model->updateNews($data);
    }
    public function deleteNewsByid($data)
    {
        $news_model = new NewsModel();
        return $news_model->deleteNewsByid($data);
    }
 
}