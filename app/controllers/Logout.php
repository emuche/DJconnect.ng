<?php

class Logout extends Controller{


    private $userModel;


    public function __construct(){
        Logged::inRedirect();
        $this->userModel = $this->model('User');
    }

    public function index(){
        $user = $this->userModel->findUserById(Session::get('id'));
       
        if(!empty($user) && is_object($user)){
            unset($user->password);
            foreach($user as $key=>$value){
                Session::delete($key);        
            }
            session_destroy();
        }

        Redirect::to('');
    }
}
    