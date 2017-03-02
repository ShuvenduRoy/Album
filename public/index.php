<?php
require_once ("../includes/database.php");
if(isset($database)){
    echo "true";
} else {
    echo "false";
}
echo "<br/>";
echo "this is working";

$sql = "insert into users values(1,'bikash', 'bikash', 'Bikash', 'Roy')";
$result = $database->query($sql);
echo $result;