<?php

/**
 * controllers/login.php
 *
 * Login manager 
 *
 * @package		Java-Geeks
 * @author		JLP
 * @copyright           Copyright (c) 2010-2013, J.L. Parry
 * @since		Version 2.0.0
 * ------------------------------------------------------------------------
 */
class Login extends Application {

    function __construct() {
        parent::__construct();
    }

    //-------------------------------------------------------------
    //  Default entry point. 
    //  We should never get here
    //-------------------------------------------------------------

    function index() {
        redirect('../');
    }
    
    // Process a login
    function submit() {
        if(!isset($_POST['id']) || !isset($_POST['password'])){
            redirect('../');
        }
        $key = $_POST['id']; //gets the userid from the LOGIN form in the _login view
        $password = md5($_POST['password']); //".." password ".."
//        echo 'key: '.$key.'<br/>';
//        echo 'password: '.$password.'<br/>';
//        exit;
       $user = $this->users->get($key);
         // what if no such user
        if ($user == null) {
        //echo 'No such user<br/>';
            redirect('../');
        }
        //check the password
        if ($password == (string) $user->password) {
            // we have a winner!
            $this->session->set_userdata('userID', $key);
            $this->session->set_userdata('userName', $user->name);
            $this->session->set_userdata('userRole', $user->role);
            redirect('../');
        } 
        else {
        //echo 'Password does not match<br/>';
            // password doesn't match
            redirect('../');
        }
    }
    
}
/* End of file login.php */
/* Location: application/controllers/login.php */