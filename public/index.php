<?php
require_once ("../includes/include.php");

$found_user = User::find_by_id(1);
echo $found_user['username'];