<?php

class Register extends Controller{

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
                'name' => ucwords(trim($_POST['name'])),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => '',
                'post_count' => $this->postCount,
                'recent_posts' => $this->recentPosts,
                'categories' => $this->categories,
            ];

            if(empty($data['name'])){
                $data['name_err'] = 'Please enter a valid name';
            }
            if(empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
                $data['email_err'] = 'Please enter a valid email';
            }elseif ($this->userModel->findUserByEmail($data['email'])) {
                $data['email_err'] = 'email is already taken';
            }
            if(empty($data['password'])){
                $data['password_err'] = 'Please enter Password';
            }elseif(!preg_match('/[A-Z]/', $data['password'])){
                $data['password_err'] = 'Password must contain Upper case';
            }elseif(!preg_match('~[0-9]+~', $data['password'])){
                $data['password_err'] = 'Password must contain Number';
            }elseif(!preg_match('/[a-z]/', $data['password'])){
                $data['password_err'] = 'Password must contain Lower case';
            }elseif(!preg_match('/[\'^£$%&*()}{@#~>?<>,|=_+¬-]/', $data['password'])){
                $data['password_err'] = 'Password must contain Special Character';
            }
            if(empty($data['confirm_password']) || !($data['password'] == $data['confirm_password'])){
                $data['confirm_password_err'] = 'Please confirm Password';
            }

            if(empty($data['name_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])){

                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                if ($this->userModel->register($data)) {

                    Session::set('register_success', '<strong>Registration Successfull</strong> Kindly check your mail to activate your account.');
                    Redirect::to('login');
                }else{
                    die('something went wrong');
                }

            }else{

                Session::set('register_failed', '<strong>Registration Failed</strong> Kindly fill the form correctly.');
                $this->view('register', $data);
            }
        } else{
            $data = [
                'name' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => '',
                'post_count' => $this->postCount,
                'recent_posts' => $this->recentPosts,
                'categories' => $this->categories,
            ];

            $this->view('register', $data);
        }
    }

}