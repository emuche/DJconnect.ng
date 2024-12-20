<?php
class Videos extends Controller{

    private $postModel;
    private $genreModel;
    private $recentPosts;
    private $categories;
    private $postCount;
    private $videoModel;

    public function __construct(){
        $this->postModel = $this->model('Post');
        $this->genreModel = $this->model('Genre');
        $this->videoModel = $this->model('Video');
        $this->recentPosts =  $this->postModel->getRecentPosts();
        $this->categories =  $this->genreModel->getGenreAndPostsCount();
        $this->postCount = Logged::in() ? $this->postModel->getUserPostsCount(Session::get('id')) : 0;

    }

    public function index($page = 1){

        $data = [
            'posts' => $this->videoModel->getVideosByPageLimit($page),
            'post_count' => $this->postCount,
            'recent_posts' => $this->recentPosts,
            'categories' => $this->categories,
        ];

        $this->view('videos', $data);
    }

}