<?php

/**
 * controllers/administer.php
 *
 * Syndication administration
 *
 * @package		Java-Geeks
 * @author		JLP
 * @copyright           Copyright (c) 2013, J.L. Parry
 * @since		Version 2.0.0
 * ------------------------------------------------------------------------
 */
class Administer extends Application {

    function __construct() {
        parent::__construct();
        $this->restrict(ROLE_ADMIN);
    }

    //-------------------------------------------------------------
    //  Show the user list
    //-------------------------------------------------------------

    function index() {
        $this->data['title'] = "Java-Geeks ~ Syndication";
        $this->build_form();
        $this->data['pagebody'] = 'admin';
        $this->render();
    }

    // Build the fields needed for the syndication admin form
    function build_form() {

        // standard text fields
        $this->data['fcode'] = makeTextField('Webapp code', 'code', $this->control->get('code'));
        $this->data['fname'] = makeTextField('Blog name', 'name', $this->control->get('name'));
        $this->data['flink'] = makeTextField('Blog link', 'link', $this->control->get('link'));
        $this->data['fslug'] = makeTextField('Plug for the blog', 'slug', $this->control->get('slug'));
        $this->data['fboss'] = makeTextField("Who's our daddy?", 'boss', $this->control->get('boss'));
        $this->data['fport'] = makeTextField("Which port he listens on?", 'port', $this->control->get('port'));

        // finally, we need the buttons
        $this->data['fsubmit'] = makeSubmitButton('Submit', 'Away we go');
        $this->data['fcancel'] = makeLinkButton('Cancel', '/blog/administer', 'Forget about it');
    }

    // Process any settings changes
    function submit() {
        // the form fields we are interested in
        $user_fields = array('code', 'name', 'link', 'slug', 'boss', 'port');

        // update our properties & build notification parameters
        foreach ($user_fields as $field) {
            $this->control->put($field, $_POST[$field]);
        }

        // build notification parameters, positional
        $req_fields = array('code', 'name', 'link', 'slug');
        $notification = array();
        foreach ($user_fields as $field) {
            $notification[] = $_POST[$field];
        }

        $this->notify_syndicate($notification);

        // back home
        $this->index();
    }

    // Notidy the syndicate, using XML-RPC
    function notify_syndicate($parms) {
        // configure our XML-RPC client
        $this->load->library('xmlrpc');
        $this->xmlrpc->server('http://' . $this->control->get('boss') . ':' . $this->control->get('port') . '/boss');
        $this->xmlrpc->method('update');
//        $this->xmlrpc->set_debug(TRUE);

        // specify the parameters
        $this->xmlrpc->request($parms);

        // send the request
        if (!$this->xmlrpc->send_request()) {
            echo $this->xmlrpc->display_error();
            exit();
        }

        // and return the response (in case interested)
        return $this->xmlrpc->display_response();
    }

    // wrap an associative array for passing as an XML-RPC request parameter
    function wrapit($parms) {
        $result = array();
        foreach ($parms as $key => $value) {
            $result[] = array(
                array($key => $value),
                'struct'
            );
        }
        $real_result = array($result, 'struct');
        return $real_result;
    }

}

/* End of file administer.php */
/* Location: ./system/application/controllers/administer.php */