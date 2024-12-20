<?php

class Home extends Controller{

    private $postModel;
    private $genreModel;
    private $userPostsCount;
    private $recentPosts;
    private $categories;

    public function __construct(){

        $this->postModel = $this->model('Post');
        $this->genreModel = $this->model('Genre');
        $this->recentPosts =  $this->postModel->getRecentPosts();
        $this->userPostsCount = Logged::in() ? $this->postModel->getUserPostsCount(Session::get('id')) : 0;
        $this->categories = $this->genreModel->getGenreAndPostsCount();
        
    }

    public function index(){
       
        Redirect::to('home/page/1');
    }


    public function page($page){

        $posts = $this->postModel->getPostsByPageLimit($page);

        $data = [
            'posts' => $posts,
            'post_count' => $this->userPostsCount,
            'recent_posts' => $this->recentPosts,
            'categories' => $this->categories,
        ];

        $this->view('home/index', $data);
    }


    public function pagenotfound(){

        $data = [
            'post_count' => $this->userPostsCount,
            'recent_posts' => $this->recentPosts,
            'categories' => $this->categories,
        ];

        $this->view('home/404', $data);
    }


    public function image(){

        $this->view('home/image');
    }

    public function genre(){
        echo 'genre';

    }

    public function search($key = null){
        Redirect::param($key);


        $this->view('home/search');
    }


}