<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Our control table.
 * Essentially a properties file.
 *
 * CREATE TABLE IF NOT EXISTS `control` (
  `name` varchar(32) NOT NULL,
  `value` varchar(255) NOT NULL,
  `purpose` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
 *
 * @package		GICC Backend
 * @author		JLP
 * @copyright	Copyright (c) 2009-2013, Galiano Island Chamber of Commerce
 * @since		Version 3.1
 * Updated              v3.18.1: Modify consume() to add record if not there
 * Updated              v4.0: Port to CI2.0
 * ------------------------------------------------------------------------
 */

class Control extends Properties {

// Constructor
    function __construct() {
        parent::__construct();
        $this->loadTable('properties','key','value');
    }

    // Consume a serial # ... return existing value & increment stored one
    function consume($key) {
        $result = 0;
        // get existing value if it exists
        if (isset($this->_data[$key])) {
            $result = $this->_data[$key];
        }
        $this->put($key,$result+1);
        return $result;
    }

}

/* End of file */
