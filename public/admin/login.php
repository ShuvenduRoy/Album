<?php
require_once ("../../includes/include.php");
if($session->is_logged_in()){
    redirect_to("index.php");
}

if(isset($_POST['submit'])){
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $found_user = User::authenticate($username, $password);

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

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../stylesheets/bootstrap.min.css">
    <link rel="stylesheet" href="../stylesheets/main.css">
    <title>Photo Album</title>
</head>
<body>
    <div class = "container">
        <div class="wrapper">
            <form action="login.php" method="post" class="form-signin">
                <h3 class="form-signin-heading">Welcome Back! Please Sign In</h3>
                <hr class="colorgraph"><br>

                <input type="text" class="form-control" name="username" placeholder="Username" required="" autofocus="" />
                <input type="password" class="form-control" name="password" placeholder="Password" required=""/>

                <button class="btn btn-lg btn-primary btn-block"  name="submit" value="Login" type="Submit">Login</button>
            </form>
        </div>
    </div>
</body>
</html>
