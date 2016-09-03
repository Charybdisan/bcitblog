<?php

/**
 * Our home page.
 * 
 * controllers/welcome.php
 *
 * ------------------------------------------------------------------------
 */
class Welcome extends Application {

    function __construct() {
        parent::__construct();
    }

    //-------------------------------------------------------------
    //  The normal pages
    //-------------------------------------------------------------

    function index() {
        $this->data['title'] = 'Home';
        $this->data['pagebody'] = 'welcome';
        //Get 3 posts for display on the front page
        $num = 0;
        $records = $this->posts->getAll_array_reversed();
        $shownPosts = array();
        foreach ($records as &$record){
            $num++;
            if($num > 3)
                break;
            $record = $this->massage($record);
            $shownPosts[$num] = $record;
            
        }
        $this->data['posts'] = $shownPosts;
        
        $this->render();
    }
    
    function massage($record) {
        $record['buttons'] = '';
        if ($this->session->userdata('userID')) {
            if ($this->session->userdata('userRole') == 'admin') {
                $record['buttons'] .= $this->parser->parse('_post_buttons', $record, true);
                $record['buttons'] .= $this->parser->parse('_comment_buttons', $record, true);
            }
            if ($this->session->userdata('userRole') == 'user')
                $record['buttons'] .= $this->parser->parse('_comment_buttons', $record, true);
        }
        return $record;
    }

}

/* End of file aboutus.php */
/* Location: application/controllers/aboutus.php */