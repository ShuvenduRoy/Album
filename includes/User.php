<?php

/**
 * Created by PhpStorm.
 * User: bikash
 * Date: 3/2/2017
 * Time: 9:37 PM
 */

require_once ('include.php');


class User extends DatabaseObject
{
    public static $table_name='users';
    public $id;
    public $username;
    public $password;
    public $first_name;
    public $last_name;

    public static function authenticate($username="", $password=""){
        global $database;
        echo $username;
        echo $password;
        $sql = "select * from users where username='{$username}' AND password='{$password}' limit 1";
        $result_set = self::find_by_sql($sql);
        if(empty($result_set)){
            echo "empty";
        }
        return !empty($result_set)?array_shift($result_set): false;
    }

    public function fullname(){
        return $this->first_name." ".$this->last_name;
    }

    public function create(){
        global $database;
        $sql = "insert into users (".
            "username , password, first_name, last_name".
            ")values('".
            $this->username."', '".
            $this->password."', '".
            $this->first_name."', '".
            $this->last_name."')";

        if($database->query($sql)){
            $this->id = $database->insert_id();
            return true;
        } else {
            return false;
        }
    }

    public function update(){

    }

}