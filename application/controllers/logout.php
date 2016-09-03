<?php

//Simply destroys a session (logs out) and redirects to the root
class Logout extends Application {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->session->sess_destroy();
        redirect('../');
    }

}
?>
