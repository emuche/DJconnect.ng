<?php

class Page extends Controller{

    private $postModel;

    public function __construct(){

        $this->postModel = $this->model('Post');
        
    }

    public function index(){
       
        $posts = $this->postModel->getAllPostsAndRelations();

        $data = [
            'posts' => $posts,
        ];

        $this->view('index', $data);
    }


    public function page($page){
        echo $page;
    }


}