<?php

class Profiles extends Controller{

    private $profileModel;
    private $userModel;
    private $postModel;
    private $genreModel;
    private $recentPosts;
    private $categories;
    private $postCount;

    public function __construct(){
        $this->profileModel = $this->model('Profile');
        $this->userModel = $this->model('User');
        $this->postModel = $this->model('Post');
        $this->genreModel = $this->model('Genre');
        $this->recentPosts =  $this->postModel->getRecentPosts();
        $this->categories =  $this->genreModel->getGenreAndPostsCount();
        $this->postCount = Logged::in() ? $this->postModel->getUserPostsCount(Session::get('id')) : 0;

    }

    public function index($username = null, $type = null, $page = 1){
        $dj = $this->userModel->findUserByUsername($username);

        if (is_int($username) || empty($dj) ) {
            Redirect::to('404');
        }

        $data = [
            'user' => $dj, 
            'dj' => $dj,
            'profile' => $this->profileModel->getProfileByUserId($dj->id),
            'post_count' => $this->postCount,
            'recent_posts' => $this->recentPosts,
            'categories' => $this->categories,

        ];

        if(!empty($username) && empty($type)){
            $this->view('profiles/profile', $data);
        }elseif(!empty($username) && $type == 'videos'){
            $data['posts'] = $this->postModel->getUserVideosPosts($dj->id, $page);
            $data['post_type'] = 'videos';
            $this->view('profiles/index', $data);
        }elseif(!empty($username) && $type == 'audios'){
            $data['posts'] = $this->postModel->getUserAudiosPosts($dj->id, $page);
            $data['post_type'] = 'audios';
            $this->view('profiles/index', $data);
        }else{
            $data['posts'] = $this->postModel->getUserPosts($dj->id, $page);
            $data['post_type'] = 'all';
            $this->view('profiles/index', $data);
        }

    }

    public function home($page = 1){

        $djs = $this->profileModel->getAllDjs($page);

        $data = [
            'djs' => $djs,
            'post_count' => $this->postCount,
            'recent_posts' => $this->recentPosts,
            'categories' => $this->categories,

        ];

        $this->view('profiles/home', $data);
    }

}