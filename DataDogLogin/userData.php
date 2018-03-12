<?php
class User{
	public $name;
	public $email;
	private $hashedPassword;
	public function setPassword($password){
		$hashedPassword = password_hash($password); 
	}
	public function checkPassword($password){
		return password_verify($password, $hashedPassword);
	}

}



?>
