<?php
include 'userData.php';
include 'Validator.php';
session_start();
if(isset($_SESSION['name'])){
    echo 'Sveiki, '.$_SESSION['name'].'!<br />Galite <a href="logout.php">atsijungti</a>.';
}else{
    if(isset($_POST['email'], $_POST['password'])){
        $validator = new Validator();
        if (($user->name = $validator->authenticate($_POST['email'], $_POST['password']))) {
            $_SESSION['name'] = $user->name;
            header('location: index.php');
        } else {
            echo 'Blogas prisijungimo vardas arba slaptažodis<br />';
        }
    }
    ?>
    <form action="DataDogLogin/index.php" method="post">
        <input type="text" name="email" placeholder="El. paštas" /><br />
        <input type="password" name="password" placeholder="Slaptažodis" /><br />
        <input type="submit" />
    </form>
<?php
}
