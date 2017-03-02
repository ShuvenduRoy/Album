<?php
require_once ("config.php");

class MySQLDatabase{
    private $connection;

    function __construct()
    {
        $this->open_connection();
    }

    public function open_connection(){
        $this->connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
        if(mysqli_errno($this->connection)){
            die("Database connection failed: " .
                mysqli_connect_error().
                "(" . mysqli_connect_errno(). ")"
            );
        }
    }

    public function close_connection()
    {
        if(isset($this->connection)){
            mysqli_close($this->connection);
            unset($this->connection);
        }
    }

    public function query($sql)
    {
        $result = mysqli_query($this->connection, $sql);

        if(!$result){
            die("Database connnection failed");
        }

        return $result;
    }

    /**
     * Database nutral functions
     */
    public function fetch_array($resutl_set)
    {
        return mysqli_fetch_array($resutl_set);
    }

    public function mysql_prep($string)
    {
        $escaped_string = mysqli_real_escape_string($this->connection, $string);
        return $escaped_string;
    }

    public function insert_id()
    {
        //Get the last id inserted into current db
        return mysqli_insert_id($this->connection);
    }

    public function affected_rows()
    {
        return mysqli_affected_rows($this->connection);
    }
}

$database = new MySQLDatabase();
$db = & $database;

?>