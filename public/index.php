<?php
require_once ("../includes/database.php");

$sql = "select * from users where id = 1";
$result = $database->query($sql);
$found_user = $database->fetch_array($result);
echo $found_user['username'];