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
        if(mysqli_errno()){
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

    public function mysql_prep($string)
    {
        $escaped_string = mysqli_real_escape_string($this->connection, $string);
        return $escaped_string;
    }
}

$database = new MySQLDatabase();
$db = & $database;

?>