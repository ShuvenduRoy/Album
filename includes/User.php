<?php

/**
 * Created by PhpStorm.
 * User: bikash
 * Date: 3/2/2017
 * Time: 9:37 PM
 */

require_once ('database.php');

class User
{
    public static function find_all()
    {
        global $database;
        $result_set = $database->query("select * from users");
        return $result_set;
    }

    public static function find_by_id($id=0)
    {
        global $database;
        $result_set = $database->query("select * from users where id={$id}");
        $found = $database->fetch_array($result_set);
        return $found;
    }
}