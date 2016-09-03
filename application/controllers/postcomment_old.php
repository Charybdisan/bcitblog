<?php

/**
 * controllers/postcomment.php
 *
 * Posting comments 
 *
 * @package		Java-Geeks
 * @author		JLP
 * @copyright           Copyright (c) 2013, J.L. Parry
 * @since		Version 2.0.0
 * ------------------------------------------------------------------------
 */
//FIXME Needs fleshing out
class Postcomment extends Application {

    function __construct() {
        parent::__construct();
        $this->restrict(array(ROLE_USER,ROLE_ADMIN));
    }

    //-------------------------------------------------------------
    //  The index should never be called!
    //-------------------------------------------------------------

    function index() {
        redirect('/view');
    }

    //-------------------------------------------------------------
    //  Trigger adding a new posting comment
    //-------------------------------------------------------------

    function add($id) {
        $this->data['title'] = "Add a Post Comment";
        $user = (array) $this->users->create();
        $this->data = array_merge($this->data, $user);
        $this->data['id'] = $id;//$user['id'];
        //$this->data['id'] = 'new';
        $this->data['pagebody'] = 'postcomment';
        $this->render();
    }

    // Request a post edit
    function edit($id) {
        $this->data['title'] = "Edit a Post Comment";
//        $user = (array) $this->users->get($id);
//        $this->data = array_merge($this->data, $user);
//        $this->data['id'] = $user['id'];
        $this->data['pagebody'] = 'postcomment';
        $this->render();
    }

    // Process an add/edit form submission
    function submit($id = null) {
        // the form fields we are interested in
        $user_fields = array('name', 'email', 'role', 'status',
            'lastvisited');

        // either create or retrieve the relevant user record
        if ($id == null || $id == 'new')
            $user = $this->users->create();
        else
            $user = $this->users->get($id);

        // over-ride the user record fields with submitted values
        fieldExtract($_POST, $user, $user_fields);

        // validate the user fields
//        if ($_POST['id'] == 'new' || empty($_POST['id']))
//            $this->data['errors'][] = 'You need to specify a userid';
//        if ($id == null && $this->users->exists($_POST['id']))
//            $this->data['errors'][] = 'That userid is already used';
//        if (strlen($user->name) < 1)
//            $this->data['errors'][] = 'You need a user name';
//        if (strlen($user->email) < 1)
//            $this->data['errors'][] = 'You need an email address';
//        if (!strpos($user->email, '@'))
//            $this->data['errors'][] = 'The email address is missing the domain';
//        if ($id == null && empty($user->password))
//            $this->data['errors'][] = 'You must specify a password';

        // if errors, redisplay the form
        if (count($this->data['errors']) > 0) {
            // over-ride the view parameters to reflect our data
            $this->data = array_merge($this->data, (array) $user);
            $this->data['pagebody'] = 'useredit';
            $this->render();
            exit;
        }

        
        // either add or update the user record, as appropriate
        if ($id == null) {
            $user->id = $_POST['id'];
            $this->users->add($user);
        }
        else
            $this->users->update($user);

        // redisplay the list of users
        redirect('/usermtce');
    }

    // Delete a user
    function delete($id) {
        $this->users->delete($id);
        $this->index();
    }

}

/* End of file postcomment.php */
/* Location: ./system/application/controllers/postcomment.php */