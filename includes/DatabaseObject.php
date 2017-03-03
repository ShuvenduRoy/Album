<?php
/**
 * Created by PhpStorm.
 * User: bikash
 * Date: 3/3/2017
 * Time: 1:42 PM
 */
require_once ('include.php');

class DatabaseObject
{
    public static function find_all()
    {
        return static::find_by_sql("select * from ".self::$table_name);
    }

    public static function find_by_id($id=0)
    {
        global $database;
        $result_array = self::find_by_sql("select * from ".static::$table_name." where id={$id}");
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

    private static function instantiate($record){
        $class_name = get_called_class();
        $object               = new $class_name;
        /*$user->id           = $record['id'];
        $user->username     = $record['username'];
        $user->password     = $record['password'];
        $user->first_name   = $record['first_name'];
        $user->last_name    = $record['last_name'];*/

        foreach ($record as $attribute=>$value){
            if($object->has_attribute($attribute)){
                $object->$attribute = $value;
            }
        }

        return $object;
    }

    private function has_attribute($attribute){
        $object_vars = get_object_vars($this);
        return array_key_exists($attribute, $object_vars);
    }
}