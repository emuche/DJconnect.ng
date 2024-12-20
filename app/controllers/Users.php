<?php

class Users extends Controller{

    private $userModel;

    public function __construct(){
        $this->userModel = $this->model('User');

    }

    public function isLoggedin(){

        $id = Session::exists('id') ? Session::get('id') : false;
        $email = Session::exists('email') ? Session::get('email') : false;
        $username = Session::exists('username') ? Session::get('username') : false;

        if($id && ($email || $username)){
            return true;
        }else{
            return false;
        }

    }

    
}