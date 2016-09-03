<?php

/**
 * controllers/usermtce.php
 *
 * User table maintenance
 *
 * @package		Java-Geeks
 * @author		JLP
 * @copyright           Copyright (c) 2013, J.L. Parry
 * @since		Version 2.0.0
 * ------------------------------------------------------------------------
 */
class Usermtce extends Application {

    function __construct() {
        parent::__construct();
        $this->restrict(ROLE_ADMIN);
        $this->load->model('errormake');
    }

    //-------------------------------------------------------------
    //  Show the user list
    //-------------------------------------------------------------

    function index() {
        $this->data['title'] = "User Maintenance";
        $users = $this->users->getAll_array();
        $this->data['users'] = $users;
        $this->data['pagebody'] = 'userlist';
        $this->render();
    }
    //-------------------------------------------------------------
    //  Check if a user exists in the DB users table
    //-------------------------------------------------------------
    function exists($uid){
        $query = $this->db->get_where('users', array('id' => $uid));
        $count= $query->num_rows();    //counting result from query
        if($count == 0){
            return 0; //does not exist in DB users table
        }
        return 1; //does exist in DB users table
    }

    //-------------------------------------------------------------
    //  Trigger adding a new user
    //-------------------------------------------------------------
    //usermtce/add
    function add() {
        $this->data['title'] = "Add a user";
        $user = (array) $this->users->create();
        $this->data = array_merge($this->data, $user);
        //$this->data['id'] = 'new';
        $this->build_user_form($user, 'new');
        $this->data['pagebody'] = 'useredit';
        $this->data['errors'] = '';
        $this->render();
    }

    // Request a user edit
    //usermtce/edit
    function edit($id) {
        $this->data['title'] = "Edit a User";
        $user = (array) $this->users->get($id);
        $this->data = array_merge($this->data, $user);
        /*
        $this->data['id'] = $user['id'];
        $this->data['password'] = ''; // assume password to remain the same
         */
        $this->build_user_form($user, $id);
        $this->data['pagebody'] = 'useredit';
        $this->data['errors'] = '';
        $this->render();
    }

    // Process an add/edit form submission
    function submit($id = null) {
        // the form fields we are interested in
        $user_fields = array('name', 'email', 'role', 'status',
            'lastvisited');
        $action = "";
        // either create or retrieve the relevant user record
        if ($id == null || $id == 'new'){
            $user = $this->users->create();
            $action = "add";
        }
        else{
            $user = $this->users->get($id);
            $action = "edit";
        }

        // over-ride the user record fields with submitted values
        fieldExtract($_POST, $user, $user_fields);
        $user->id = $_POST['id'];
        $errors = array();
        // validate the user fields
        if ($_POST['id'] == 'new' || empty($_POST['id']))
            $errors[0] = 'You need to specify a userid';
        if ($id == null && $this->users->exists($_POST['id']))
            $errors[1] =  'That userid is already used';
        if (strlen($user->name) < 1)
            $errors[2] = 'You need a user name';
        if (strlen($user->email) < 1)
            $errors[3] = 'You need an email address';
        if (!strpos($user->email, '@'))
            $errors[4] = 'The email address is missing the domain';
        if ($id == null && empty($user->password))
            $errors[5] = 'You must specify a password';
        if($action == "add" && $this->exists($_POST['id']) == 1)
            $errors[6] = 'There is all ready someone with this user ID.';
        // if errors, redisplay the form
        //var_dump($errors);
        if (count($errors) > 0) {
            // over-ride the view parameters to reflect our data
            
            //$this->data = array_merge($this->data, (array) $user);
            //$this->build_user_form((array) $user, $id);
            $this->data['pagebody'] = 'errors';
            $this->data['title'] = "Error";
            
           $theaction = "";
            if($action == "edit")
                $theaction .= $action . "/" . $id;
            $error_title = "User Maintenance | (" . $action . ")";
            $this->data['showerrors'] = $this->errormake->build_errors($error_title, $errors);
            $this->data['goback'] = makeLinkButton('Go Back', '/blog/usermtce/' . $theaction, 'Go back to previous page');
            $this->render();
            return;
            /*
            $theid = "";
            if($action == "edit")
                $theid = $id;
            /redirect('/usermtce/' . $action . "/" . $theid);
             */
        }
        // handle the password specially, as it needs to be encrypted
        $new_password = $_POST['password'];
        //$thePass = $user['password'];
        if (!empty($new_password)) {
            $new_password = md5($new_password);
            if ($new_password != $user->password)
                $user->password = $new_password;
        }
        
        $user->lastvisit = $_POST['lastvisit'];
        
        // either add or update the user record, as appropriate
        if ($id == 'new') {
            $user->id = $_POST['id'];
            $this->users->add($user);
        }
        else{
            $user->id = $_POST['id'];
            $this->users->update($user);
        }

        // redisplay the list of users
        redirect('../usermtce');
    }
    
    // Delete a user
    function delete($id) {
        $this->users->delete($id);
        $this->index();
    }
    
    
    function build_user_form($record, $id) {

        $this->data['id'] = $id;

        // standard text fields
        $this->data['fid'] = makeTextField('Userid', 'id', $id);
        $this->data['fname'] = makeTextField('User name', 'name', $record['name']);
        $this->data['femail'] = makeTextField('Email address', 'email', $record['email']);

        // password should start blank. admin can override it
        $this->data['fpassword'] = makePasswordField('Password', 'password', '', 'Plaintext; over-ride if changed.');

        // role needs selections
        $user_roles = array(ROLE_VISITOR => 'Social User', ROLE_USER => 'Normal user', ROLE_ADMIN => 'Administrator');
        $this->data['frole'] = makeComboField('Role', 'role', $record['role'], $user_roles);

        // date last visited needs a datepicker
        $this->data['flastvisit'] = makeTextField('Date last visited', 'lastvisit', $record['lastvisit']);
        makeDateSelector('Date last visited', "lastvisit", $record['lastvisit']);

        // status needs a combo box
        $status_codes = array('A' => 'Active', 'D' => 'Disabled');
        $this->data['fstatus'] = makeComboField('Status', 'status', $record['status'], $status_codes);

        // finally, we need the buttons
        $this->data['fsubmit'] = makeSubmitButton('Submit', 'Away we go');
        $this->data['fcancel'] = makeLinkButton('Cancel', '/blog/usermtce', 'Forget about it');
    }

}

/* End of file usermtce.php */
/* Location: ./system/application/controllers/usermtce.php */