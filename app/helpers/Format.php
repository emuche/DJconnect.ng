<?php
class Format{

    public static function date($date){
        return date('dS M, Y',strtotime($date));
    }


    public static function cap($text){
        return ucwords($text);  
    }

 
}
?>