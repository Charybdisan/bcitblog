<?php

class Users extends _Mymodel {

    // Constructor
    function __construct() {
        parent::__construct();
        $this->setTable('users', 'id');
    }

}