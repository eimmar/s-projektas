<?php
/**
 * Created by PhpStorm.
 * User: eimantas
 * Date: 18.3.13
 * Time: 00.02
 */
include 'config.php';
class Validator
{
    /**
     * @var User[]|array
     */
    private $users;
   /** public function __construct()
    {
        $user = new User();
        $user->name = 'artojas';
        $user->email = 'data@dog.lt';
        $user->setPassword('admin');
        $this->users[] = $user;
    }
	*/
    /**
     * @param string $email
     * @param string $password
     * @return bool|User
     */
    public function authenticate($email, $password)
    {
	$query="SELECT * FROM 'user' WHERE email='$email' and password='$password'";
	$result=mysqli_query($connection, $query) or die(mysqli_error($connection));
	$count=mysqli_num_rows($result);
	if($count===1){
	return false;
	}
	else{
	return false;
	}
	/**
        foreach ($this->users as $user) {
            if ($user->email === $email && $user->checkPassword($password)) {
                return $user;
            }
        }
        return false;
	*/
    }
}
