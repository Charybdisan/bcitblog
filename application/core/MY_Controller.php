<?php
/**
 * core/MY_Controller.php
 *
 * Default application controller
 *
 * @author		JLP
 * @copyright           2010-2013, James L. Parry
 * ------------------------------------------------------------------------
 */
class Application extends CI_Controller {

    
    protected $data = array();      // parameters for view components
    protected $id;                  // identifier for our content

    /**
     * Constructor.
     * Establish view parameters & load common helpers
     */

    function __construct() {
        parent::__construct();
        //TEMPORARY!!!!!!
        /*
            echo "TODO:<br/>";
            echo "about page, changes width?<br/>";
            echo "cant delete items from hostpapa (via phpmyadmin)?<br/>";
            echo "LATER: limit number of posts per page, PAGINATION";
         */
        $this->data = array();
        $this->data['title'] = '?';
        $this->data['errors'] = array();
        $this->errors = array();
        $this->data['pageTitle'] = '??';        
    }

    /**
     * Render this page
     */
    function render() {
        $this->data['menubar'] = $this->build_menu_bar($this->config->item('menu_choices'));
        $this->data['content'] = $this->parser->parse($this->data['pagebody'], $this->data, true);
        $this->data['login_form'] = $this->build_login_panel();
        $this->data['sessionid'] = $this->session->userdata('session_id');
        
        $this->data['caboose_styles'] = $this->caboose->styles();
        $this->data['caboose_scripts'] = $this->caboose->scripts();
        $this->data['caboose_trailings'] = $this->caboose->trailings();
        
        // finally, build the browser page!
        $this->data['data'] = &$this->data;
        $this->parser->parse('_template', $this->data);
    }

    /**
     * Build an unordered list of linked items, such as used for a menu bar.
     * @param mixed $choices Array of name=>link pairs
     */
    function build_menu_bar($choices) {
        $menudata = array();
        foreach ($choices as $name => $link)
            $menudata['menudata'][] = array('menulink' => $link, 'menuname' => $name);
        return $this->parser->parse('_menubar', $menudata, true);
    }
    
    function build_login_panel() {
        $result = '';

        //If we are all ready logged in
        if ($this->session->userdata('userID')) {
            $ext_data = $this->session->all_userdata();
            //If we are an admin, we can parse an administration menu
            $ext_data['admin_menu'] = '';
            if ($this->session->userdata('userRole') == 'admin')
                $ext_data['admin_menu'] = $this->parser->parse('_admin', $ext_data, true);
            $ext_data['flogout'] = makeLinkButton('Logout', '/blog/logout', 'Click here to logout!');
            $result .= $this->parser->parse('_loggedin', $ext_data, true);
        } else {
            // show the login form
            $this->data['fid'] = makeTextField('Userid', 'id', '', '', 12, 12);
            $this->data['fpassword'] = makePasswordField('Password', 'password', '', '', 12, 12);
            $this->data['fcomment'] = makeBogusField('Comment', 'comment');
            $this->data['fsubmit'] = makeSubmitButton('Submit', 'Come on, go for it!');
            // show the login form
            $result .= $this->parser->parse('_login', $this->data, true);
            //$result .= $this->load->view('_login', $this->data, true);
        }

        // links
        //$result .= $this->link_away();

        return $result;
    }
    
    /**
     * Enforce role-based authentication.
     * @param string $roleNeeded 
     */
    function restrict($roleNeeded = null) {
        // if we need a role, turn away anyone without the right role
        if ($roleNeeded != null) {
            $userRole = $this->session->userdata('userRole');
            if (!$userRole) {
                // no one is logged in, goodbye
                redirect("http://" . $_SERVER['HTTP_HOST'] . "/blog");
                exit;
            }
            // logged in. check the role they have
            if (is_array($roleNeeded)) {
                if (!in_array($userRole, $roleNeeded)) {
                    // Not authorized. Redirect to home page
                    redirect("http://" . $_SERVER['HTTP_HOST'] . "/blog");
                    exit;
                }
            } elseif ($userRole != $roleNeeded) {
                redirect("http://" . $_SERVER['HTTP_HOST'] . "/blog");
                exit;
            }
        }
    }

}

/* End of file MY_Controller.php */
/* Location: application/core/MY_Controller.php */