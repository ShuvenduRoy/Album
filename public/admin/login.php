<?php
require_once ("../../includes/include.php");
if($session->is_logged_in()){
    redirect_to("index.php");
}

if(isset($_POST['submit'])){
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $found_user = "";

    if($found_user){
        $session->login($found_user);
        redirect_to("index.php");
    } else {
        $message = "User name or password is incorrent";
    }
} else {
    $username = "";
    $password = "";
}
?>