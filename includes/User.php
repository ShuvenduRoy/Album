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
    public $id;
    public $username;
    public $password;
    public $first_name;
    public $last_name;

    public static function find_all()
    {
        return self::find_by_sql("select * from users");
    }

    public static function find_by_id($id=0)
    {
        global $database;
        $result_array = self::find_by_sql("select * from users where id={$id}");
        return !empty($result_array) ? array_shift($result_array):false;
    }

    public static function find_by_sql($sql="")
    {
        global $database;
        $result_set = $database->query($sql);
        $object_array = array();

        while ($row = $database->fetch_array($result_set)){
            $object_array[] = self::instantiate($row);
        }

        return $object_array;
    }

    public static function authenticate($username="", $Password=""){
        global $database;
        $sql = "select * from users where username='{usename}' AND password='{password}' limit 1";
        $result_set = self::find_by_sql($sql);
        return !empty($result_set)?array_shift($result_set): false;
    }

    private static function instantiate($record){
        $user               = new User();
        /*$user->id           = $record['id'];
        $user->username     = $record['username'];
        $user->password     = $record['password'];
        $user->first_name   = $record['first_name'];
        $user->last_name    = $record['last_name'];*/

        foreach ($record as $attribute=>$value){
            if($user->has_attribute($attribute)){
                $user->$attribute = $value;
            }
        }

        return $user;
    }

    private function has_attribute($attribute){
        $object_vars = get_object_vars($this);
        return array_key_exists($attribute, $object_vars);
    }

    public function fullname(){
        return $this->first_name." ".$this->last_name;
    }
}