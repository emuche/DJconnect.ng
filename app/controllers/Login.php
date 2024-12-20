<?php

class Login extends Controller{

    private $userModel;
    private $postModel;
    private $genreModel;
    private $recentPosts;
    private $categories;
    private $postCount;


    public function __construct(){
        Logged::outRedirect();

        $this->userModel = $this->model('User');
        $this->postModel = $this->model('Post');
        $this->genreModel = $this->model('Genre');
        $this->recentPosts =  $this->postModel->getRecentPosts();
        $this->categories =  $this->genreModel->getGenreAndPostsCount();
        $this->postCount = Logged::in() ? $this->postModel->getUserPostsCount(Session::get('id')) : 0;
        
    }

    public function index(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
           
    
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => '',
                'post_count' => $this->postCount,
                'recent_posts' => $this->recentPosts,
                'categories' => $this->categories,
            ];

            
            if(empty($data['email'])){
                $data['email_err'] = 'Please enter a valid email';
            }
            if(empty($data['password'])){
                $data['password_err'] = 'Please enter Password';
            }

            if(((filter_var($data['email'], FILTER_VALIDATE_EMAIL) && !$this->userModel->findUserByEmail($data['email']) )) || (!filter_var($data['email'], FILTER_VALIDATE_EMAIL) && empty($this->userModel->findUserByUsername($data['email']))) ){
                    $data['email_err'] = 'This email/username does not exist';
            }

            if(empty($data['email_err']) && empty($data['password_err'])){

                $loggedInUser = $this->userModel->login($data['email'], $data['password']);
                if ($loggedInUser) {
                    $this->createUserSession($loggedInUser);
                    Redirect::to('');
                }else{
                    Session::set('failed_login', 'Credentials does\'nt match');
                    $data['password_err'] = 'incorrect password';
                    $this->view('login', $data);
                }
            }else{
               
                $this->view('login', $data);
            }


        } else{
            $data = [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => '',
                'post_count' => $this->postCount,
                'recent_posts' => $this->recentPosts,
                'categories' => $this->categories,
            ];

            $this->view('login', $data);
        }
    }

    public function createUserSession($loggedInUser){

        $loggedInUser = (array)$loggedInUser;
        
        if(is_array($loggedInUser)){
            unset($loggedInUser['password']);
            unset($loggedInUser['recovery_hash']);
            foreach($loggedInUser as $key=>$value){
                Session::set($key, $value);        
            }
        }

    }
}