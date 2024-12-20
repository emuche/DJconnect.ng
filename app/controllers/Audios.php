<?php
class Audios extends Controller{

    private $postModel;
    private $genreModel;
    private $recentPosts;
    private $categories;
    private $postCount;
    private $audioModel;

    public function __construct(){
        $this->postModel = $this->model('Post');
        $this->genreModel = $this->model('Genre');
        $this->audioModel = $this->model('Audio');
        $this->recentPosts =  $this->postModel->getRecentPosts();
        $this->categories =  $this->genreModel->getGenreAndPostsCount();
        $this->postCount = Logged::in() ? $this->postModel->getUserPostsCount(Session::get('id')) : 0;

    }

    public function index($page = 1){

        $data = [
            'posts' => $this->audioModel->getaudiosByPageLimit($page),
            'post_count' => $this->postCount,
            'recent_posts' => $this->recentPosts,
            'categories' => $this->categories,
        ];

        $this->view('audios', $data);
    }

}