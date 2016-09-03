<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Comments table.
 *
 * @author		Taylor Lino
 * ------------------------------------------------------------------------
 */
class Comments extends _Mymodel {

    // Constructor
    function __construct() {
        parent::__construct();
        $this->setTable('comments', 'cid');
    }

    //This...doesn't even get called?
    function newest() {
        $this->db->order_by($this->_keyField, 'desc');
        $this->db->limit(3);
        $query = $this->db->get($this->_tableName);
        return $query->result_array(); 
    }

}

/* End of file comments.php */
/* Location: application/models/comments.php */