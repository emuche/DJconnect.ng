<?php

class ForgotPassword extends Controller{

    private $userModel;
    private $postModel;
    private $genreModel;
    private $recentPosts;
    private $categories;
    private $postCount;

    public function __construct(){
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
                'email' => trim($_POST['email'])
            ];

            
            if(empty($data['email'])){
                $data['email_err'] = 'Please enter a valid email';
            }
           

            if(((filter_var($data['email'], FILTER_VALIDATE_EMAIL) && !$this->userModel->findUserByEmail($data['email']) )) || (!filter_var($data['email'], FILTER_VALIDATE_EMAIL) && empty($this->userModel->findUserByUsername($data['email']))) ){
                    $data['email_err'] = 'This email or username does not exist';
            }

            if(empty($data['email_err'])){



                echo 'success';

               
            }else{
                $this->view('forgot-password', $data);
            }
        } else{
            $data =  [
                'email'=> '',
                'post_count' => $this->postCount,
                'recent_posts' => $this->recentPosts,
                'categories' => $this->categories,
            ];
            $this->view('forgot-password', $data);
        }
       
    }


    public function recover($hash = null, $email = null){


        $user = $this->userModel->findUserByEmail($email);

        if(empty($user) || ($user->recovery_hash != $hash)){
            Redirect::to();
        }else{

            echo 'success';

        }
    }


}