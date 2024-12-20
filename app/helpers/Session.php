<?php
session_start();
class Session{

	public static function exists($name){
		return (isset($_SESSION[$name])) ? true : false;
	}

	public static function set($name, $value){
		return $_SESSION[$name] = $value;
	}

	public static function get($name){
		if(self::exists($name)){
			$session = $_SESSION[$name];
			return $session;
		}else{
			return false;
		}
	}

	public static function delete($name){
		if(self::exists($name)){
			unset($_SESSION[$name]);
		}
	}
	public static function flash($name){
		if(self::exists($name)){
			$session = self::get($name);
			self::delete($name);
			return $session;
		}else{
			return false;
		}
	}

	public static function check($name, $value){
		if(self::exists($name) && (self::get($name) == $value)){
			return true;
		}else{
			return false;
		}
	}
} 

?>