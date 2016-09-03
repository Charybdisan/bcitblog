<?php

/**
 * Our statistics page. (trends)
 * 
 * controllers/trends.php
 *
 * ------------------------------------------------------------------------
 */
class Trends extends Application {

    function __construct() {
        parent::__construct();
        $this->load->model('production');
    }

    //-------------------------------------------------------------
    //  The normal pages
    //-------------------------------------------------------------
    
    function index() {
        $this->data['title'] = 'Trends';
        $filename = XML_FOLDER . 'champions.xml';
        //$this->data['stuff'] = display_file($filename);
        
        $this->data['stuff'] = $this->_build_champion_report();
        $this->data['pagebody'] = 'trends';
        $this->render();
    }
    
    function _build_champion_report(){
            $lanes = $this->production->build_lanes();
            $data = array(
                'trends_title' => 'Champions by pick rate and ban rate for the year ' . $this->production->get_year(),
                'lanes' => $lanes,
                'pickedoverall' => $this->production->get_picked_overall(),
                'bannedoverall' => $this->production->get_banned_overall()
            );
        return $this->parser->parse('champion_report', $data, true);
    }

}

/* End of file trends.php */
/* Location: application/controllers/trends.php */