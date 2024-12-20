<?php

class Redirect{

	public static function to($location = 'index', $param1 = null, $param2 = null, $param3 = null, $param4 = null, $param5 = null){
                
                if(($location == 'index') || ($location == 'home') ){
                        $location = '';
                }elseif($location == '404'){
                        $location = 'home/pagenotfound';
                }

                $param1 = !empty($param1) ? '/'.str_replace(' ','-', $param1) : '';
                $param2 = !empty($param2) ? '/'.str_replace(' ','-', $param2) : '';
                $param3 = !empty($param3) ? '/'.str_replace(' ','-', $param3) : '';
                $param4 = !empty($param4) ? '/'.str_replace(' ','-', $param4) : '';
                $param5 = !empty($param5) ? '/'.str_replace(' ','-', $param5) : '';

                header('location: '.URLROOT.'/'.$location.$param1.$param2.$param3.$param4.$param5);
                exit();
	}

        public static function link($location = 'index', $param1 = null, $param2 = null, $param3 = null, $param4 = null, $param5 = null){

                if(($location == 'index') || ($location == 'home') ){
                        $location = '';
                }elseif($location == '404'){
                        $location = 'home/pagenotfound';
                }	

                $param1 = !empty($param1) ? '/'.str_replace(' ','-', $param1) : '';
                $param2 = !empty($param2) ? '/'.str_replace(' ','-', $param2) : '';
                $param3 = !empty($param3) ? '/'.str_replace(' ','-', $param3) : '';
                $param4 = !empty($param4) ? '/'.str_replace(' ','-', $param4) : '';
                $param5 = !empty($param5) ? '/'.str_replace(' ','-', $param5) : '';

                return URLROOT.'/'.$location.$param1.$param2.$param3.$param4.$param5;
        }

        public static function param($param = null){
                if(empty($param)){
                        self::to('404');
                }

        }

}

?>