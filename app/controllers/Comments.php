<?php 
class Comments extends Controller{

    private $userModel;
    private $postModel;
    private $commentModel;
    private $profileModel;

    public function __construct(){
        $this->userModel = $this->model('User');
        $this->postModel = $this->model('Post');
        $this->commentModel = $this->model('Comment');
        $this->profileModel = $this->model('Profile');
        
    }

    public function index(){

    }

    public function create($title, $id){

        Redirect::param($title);

       


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {


            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
            $data = [
                'name' => ucwords(trim($_POST['name'])),
                'email' => trim($_POST['email']),
                'comment' => trim($_POST['comment']),
                'website' => trim($_POST['website']),
                'token' => trim($_POST['csrf_token']),
                'name_err' => '',
                'email_err' => '',
                'comment_err' => '',
                'website_err' => '',
            ];

             Csrf::check($data['token']);

            if(Logged::in()){
                $user = $this->userModel->findUserById(Session::get('id'));
                $profile = $this->profileModel->getProfileByUserId(Session::get('id'));

                $data = [
                    'name' => $user->name,
                    'email' => $user->email,
                    'website' => $profile->website
                ];

                if(empty($data['comment'])){
                    $data['comment_err'] = 'Please enter valid Comment';
                }

            }else{
                if(empty($data['name'])){
                    $data['name_err'] = 'Please enter a valid name';
                }
                if(empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
                    $data['email_err'] = 'Please enter a valid email';
                }
                if(empty($data['comment'])){
                    $data['comment_err'] = 'Please enter valid Comment';
                }
                
            }

           
            

        //     if(empty($data['name_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])){

        //         $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        //         if ($this->userModel->register($data)) {

        //             Session::set('register_success', '<strong>Registration Successfull</strong> Kindly check your mail to activate your account.');
        //             Redirect::to('login');
        //         }else{
        //             die('something went wrong');
        //         }

        //     }else{

        //         Session::set('register_failed', '<strong>Registration Failed</strong> Kindly fill the form correctly.');
        //         $this->view('register', $data);
        //     }
        // } else{
        //     $data = [
        //         'name' => '',
        //         'email' => '',
        //         'password' => '',
        //         'confirm_password' => '',
        //         'name_err' => '',
        //         'email_err' => '',
        //         'password_err' => '',
        //         'confirm_password_err' => '',
        //     ];

            Session::set('name_err', $data['name_err']);
            Session::set('email_err', $data['email_err']);
            Session::set('comment_err', $data['comment_err']);


            Redirect::to('details', $title, $id);
        }

    }

}