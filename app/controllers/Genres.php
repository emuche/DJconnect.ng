<?php
class Genres extends Controller{

    private $userModel;
    private $postModel;
    private $commentModel;
    private $genreModel;
    private $profileModel;
    private $recentPosts;
    private $categories;
    private $postCount;
    private $db;

    public function __construct(){

        $this->profileModel = $this->model('Profile');
        $this->postModel = $this->model('Post');
        $this->commentModel = $this->model('Comment');
        $this->genreModel = $this->model('Genre');
        $this->recentPosts =  $this->postModel->getRecentPosts();
        $this->categories =  $this->genreModel->getGenreAndPostsCount();
        $this->postCount = Logged::in() ? $this->postModel->getUserPostsCount(Session::get('id')) : 0;

    }

    public function index($genre = null, $page = 'page', $pagenum = 1){

        $genres = $this->genreModel->getAllGenreAndPostAlpha();

        $data = [
            'genres' => $genres,
            'post_count' => $this->postCount,
            'recent_posts' => $this->recentPosts,
            'categories' => $this->categories,
        ];

        if (!empty($genre) && is_string($genre) && !empty($page) && $page == 'page') {     
            $genre = str_replace('-', ' ', $genre);
            $data['genre'] = $this->genreModel->getGenreByTitle($genre);
            $data['posts'] = $this->postModel->getAllPostsBygenre($genre, $pagenum);
            $this->view('genres/pages', $data);
        }else{
            $this->view('genres/index', $data);
        }
    }

}