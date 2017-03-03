<?php
require_once ("../../includes/include.php");
if(!$session->is_logged_in()){
    redirect_to('login.php');
}
?>

<?php include('../layouts/header.php')?>

    <h2>Photo album</h2>

<?php include('../layouts/footer.php')?>