<?php
if(isset($_SESSION['name'])){
    echo 'Sveiki, '.$_SESSION['name'];
}else{
    if(isset($_POST['name'], $_POST['password'])){
        /*
         *
         *
         *all login logic goes here
         *
         *
         */
        $verified = false;//do we have a user that has given name and password?
        if($verified){
            $_SESSION['name'] = $_POST['name'];
            header("location: index.php");
        }else{
            echo 'Blogas prisijungimo vardas arba slaptažodis<br />';
        }
    }
    ?>
    <form action="index.php" method="post">
        <input type="text" name="name" placeholder="Vardas" /><br />
        <input type="password" name="password" placeholder="Slaptažodis" /><br />
        <input type="submit" />
    </form>
<?php
}