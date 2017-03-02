<?php
require_once ("../includes/include.php");

$user = User::find_by_id(1);
echo $user->fullname();