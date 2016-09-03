<?php

/**
 * controllers/errors.php
 *
 * LolWizards website, template driven
 *
 * @package		LolWizards
 * @author		TLino KHipolito
 * @copyright           Copyright (c) 2014 Taylor L. Kevin H.
 * @since		Version 2.0.0
 * ------------------------------------------------------------------------
 */
class About extends Application {

    function __construct() {
        parent::__construct();
    }

    //-------------------------------------------------------------
    //  The normal pages
    //-------------------------------------------------------------

    function index() {
        $this->data['title'] = "Errors";
        $this->data['pagebody'] = 'errors';
        $this->render();
    }

}

/* End of file errors.php */
/* Location: ./system/application/controllers/errors.php */