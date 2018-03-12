<?php
include 'userData.php';
use User;
session_start();
if(isset($_SESSION['name'])){
    echo 'Sveiki, '.$_SESSION['name'].'!<br />Galite <a href="logout.php">atsijungti</a>.';
}else{
    if(isset($_POST['email'], $_POST['password'])){
        /*
         *
         *
         *all login logic goes here
         *
         *
         */
        if($_POST['email'] == 'data@dog.lt' && $_POST['password'] == 'admin'){ //just a temporary placeholder
            $_SESSION['name'] = 'Vardas';
            header('location: index.php');
        }else{
            echo 'Blogas prisijungimo vardas arba slaptažodis<br />';
        }
    }
    ?>
    <form action="index.php" method="post">
        <input type="text" name="email" placeholder="El. paštas" /><br />
        <input type="password" name="password" placeholder="Slaptažodis" /><br />
        <input type="submit" />
    </form>
<?php
}