<?php

/**
 * Our contact us page.
 * 
 * controllers/contactus.php
 *
 * ------------------------------------------------------------------------
 */
class ContactUs extends Application {

    function __construct() {
        parent::__construct();
    }

    //-------------------------------------------------------------
    //  The normal pages
    //-------------------------------------------------------------

    function index() {
        $this->data['title'] = 'Contact Us';
        $this->data['pagebody'] = 'contactus';
        $this->render();
    }

}

/* End of file contactus.php */
/* Location: application/controllers/contactus.php */