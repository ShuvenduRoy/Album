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
        return self::find_by_sql("select * from users");
    }

    public static function find_by_id($id=0)
    {
        global $database;
        $result_set = $database->query("select * from users where id={$id}");
        $found = $database->fetch_array($result_set);
        return $found;
    }

    public static function find_by_sql($sql=""){
        global $database;
        $result_set = $database->query($sql);
        return $result_set;
    }
}