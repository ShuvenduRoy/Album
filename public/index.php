<?php
require_once ("../includes/include.php");

$record = User::find_by_id(1);
echo $record['username'];