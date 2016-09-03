<?php

/**
 * Our about us.
 * 
 * controllers/aboutus.php
 *
 * ------------------------------------------------------------------------
 */
class AboutUs extends Application {

    function __construct() {
        parent::__construct();
    }

    //-------------------------------------------------------------
    //  The normal pages
    //-------------------------------------------------------------

    function index() {
        $this->data['title'] = 'About Us';
        $this->data['pagebody'] = 'aboutus';
        $this->render();
    }

}

/* End of file aboutus.php */
/* Location: application/controllers/aboutus.php */