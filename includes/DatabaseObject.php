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

    protected function sanitized_attributes() {
        global $database;
        $clean_attributes = array();
        // sanitize the values before submitting
        // Note: does not alter the actual value of each attribute
        foreach($this->attributes() as $key => $value){
            $clean_attributes[$key] = $database->escape_value($value);
        }
        return $clean_attributes;
    }

    public function save() {
        // A new record won't have an id yet.
        return isset($this->id) ? $this->update() : $this->create();
    }

    public function create() {
        global $database;
        // Don't forget your SQL syntax and good habits:
        // - INSERT INTO table (key, key) VALUES ('value', 'value')
        // - single-quotes around all values
        // - escape all values to prevent SQL injection
        $attributes = $this->sanitized_attributes();
        $sql = "INSERT INTO ".static::$table_name." (";
        $sql .= join(", ", array_keys($attributes));
        $sql .= ") VALUES ('";
        $sql .= join("', '", array_values($attributes));
        $sql .= "')";
        if($database->query($sql)) {
            $this->id = $database->insert_id();
            return true;
        } else {
            return false;
        }
    }

    public function update() {
        global $database;
        // Don't forget your SQL syntax and good habits:
        // - UPDATE table SET key='value', key='value' WHERE condition
        // - single-quotes around all values
        // - escape all values to prevent SQL injection
        $attributes = $this->sanitized_attributes();
        $attribute_pairs = array();
        foreach($attributes as $key => $value) {
            $attribute_pairs[] = "{$key}='{$value}'";
        }
        $sql = "UPDATE ".static::$table_name." SET ";
        $sql .= join(", ", $attribute_pairs);
        $sql .= " WHERE id=". $database->escape_value($this->id);
        $database->query($sql);
        return ($database->affected_rows() == 1) ? true : false;
    }

    public function delete() {
        global $database;
        // Don't forget your SQL syntax and good habits:
        // - DELETE FROM table WHERE condition LIMIT 1
        // - escape all values to prevent SQL injection
        // - use LIMIT 1
        $sql = "DELETE FROM ".static::$table_name;
        $sql .= " WHERE id=". $database->escape_value($this->id);
        $sql .= " LIMIT 1";
        $database->query($sql);
        return ($database->affected_rows() == 1) ? true : false;

        // NB: After deleting, the instance of User still
        // exists, even though the database entry does not.
        // This can be useful, as in:
        //   echo $user->first_name . " was deleted";
        // but, for example, we can't call $user->update()
        // after calling $user->delete().
    }
}