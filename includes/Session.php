<?php
/**
 * Created by PhpStorm.
 * User: bikash
 * Date: 3/2/2017
 * Time: 11:59 PM
 */

class Session{
    private $logged_in = false;
    private $user_id;
    public $username;

    function __construct()
    {
        session_start();
        $this->check_login();
    }

    public function is_logged_in(){
        return $this->logged_in;
    }

    public function login($user){
        if($user){
            $this->user_id = $_SESSION['user_id'] = $user->id;
            $this->logged_in = true;
            $this->username = $user->username;
        }
    }

    public function logout(){
        unset($_SESSION['user_id']);
        unset($this->user_id);
        $this->logged_in = false;
        unset($this->username);
    }

    private function check_login(){
        if(isset($_SESSION['user_id'])){
            $this->user_id = $_SESSION['user_id'];
            $this->logged_in = true;
        } else{
            unset($this->user_id);
            $this->logged_in = false;
        }
    }
}
$session = new Session();
