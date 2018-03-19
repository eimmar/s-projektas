<?php
class User
{
	public $name;
	public $email;
	private $hashedPassword;
	public function setPassword($password)
	{
		$this->hashedPassword = password_hash($password, PASSWORD_BCRYPT);
	}
	public function checkPassword($password)
	{
		return password_verify($password, $this->hashedPassword);
	}
}
