<?php

/**
 * Our why choose us? page.
 * 
 * controllers/whychooseus.php
 *
 * ------------------------------------------------------------------------
 */
class WhyChooseUs extends Application {

    function __construct() {
        parent::__construct();
    }

    //-------------------------------------------------------------
    //  The normal pages
    //-------------------------------------------------------------

    function index() {
        $this->data['title'] = 'Why Choose Us?';
        $this->data['pagebody'] = 'whychooseus';
        $this->render();
    }

}

/* End of file whychooseus.php */
/* Location: application/controllers/whychooseus.php */