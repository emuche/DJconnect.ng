<?php

class Logged{

    public static function check(){

        $id = Session::exists('id') ? Session::get('id') : false;
        $email = Session::exists('email') ? Session::get('email') : false;
        $username = Session::exists('username') ? Session::get('username') : false;

        if($id && ($email || $username)){
            return true;
        }else{
            return false;
        }

    }

    public static function in(){
       return self::check();
    }

    public static function link(){
        Redirect::to('index');
    }


    public static function inRedirect(){
        if(!self::check()){
            self::link();
        }
    }


    public static function outRedirect(){
        if(self::check()){
            self::link();
        }
    }

 


}
?>