<?php
$connection=mysqli_connect('localhost','root', 'S.projektas2018', 'Login');
if(!$connection){
die("Database Connection Failed" . mysqli_error($connection));
}
$select_db=mysqli_select_db($connection, 'Login');
if(!$select_db){
die("Database Selection Failed" . mysqli_error($connection));
}
?>
