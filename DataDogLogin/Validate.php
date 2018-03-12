<?php
include 'userData.php';
use User;
class Validate{
    public function cheak($users, $name, $password)
    {
        foreach ($users as $user) {
            if ($user->name === $name && $user->password === $password)
                return true;
            else
                return false;
        }
    }
}
?>
