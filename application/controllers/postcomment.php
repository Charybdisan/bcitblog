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
        $this->load->model('errormake');
    }

    //-------------------------------------------------------------
    //  The index should never be called!
    //-------------------------------------------------------------

    function index() {
        redirect('/blog/view');
    }
    
    // Edit a comment
    function edit($cid) {
        $comment = $this->comments->get($cid);
        $postid = $comment->pid;
        $this->data['title'] = "Edit a Post Comment";
        $this->data['pagebody'] = 'editcomment';
        $this->data['id'] = $comment->cid;
        $this->data['c_user'] = $comment->author;
        $this->data['c_text'] = $comment->text;
        $this->data['postid'] = $postid;
        $this->data['fsubmit'] = makeSubmitButton('Submit', 'Come on, go for it!');
        $this->data['fcancel'] = makeLinkButton('Cancel', '/blog/view/post/' . $postid, 'Forget about it');
        $this->render();
    }

    // Process an add/edit form submission
    function submit($cid) {
        // the form fields we are interested in       
        $postid = $_POST['postid'];
        $text = htmlentities($_POST['text']);

        
        // either create or retrieve the relevant comment
        if ($cid == null || $cid == 'new'){
            $comment = $this->comments->create();
            $action = "add";
        }
        else{
            $comment = (array) $this->comments->get($cid);
            $action = "edit";
        }

        $theAuthor = (string) $this->session->userdata('userID');
        
        $errors = array();
        
        if ($text == "")
            $errors[0] = 'You need content for your comment.';
        if (count($errors) > 0) {
            $this->data['pagebody'] = 'errors';
            $this->data['title'] = "Error";
            
            $error_title = "Comments | (" . $action . ")";
            $this->data['showerrors'] = $this->errormake->build_errors($error_title, $errors);
            $this->data['goback'] = makeLinkButton('Go Back', '../../view/post/' . $postid , '/', 'Go back to previous page');
            $this->render();
            return;   
        }
        
        //ADDING A COMMENT
        if ($action == "add"){
            $filteredText = $text;
            $comment->pid = $postid;
            $comment->author = $theAuthor;
            $comment->cdate = date(DATE_FORMAT);
            $comment->text = $filteredText;
            $this->comments->add($comment);
            $theID = $this->db->insert_id();
        }
        //EDITING A COMMENT
        else if ($action == "edit"){
            $comment['text'] = $text;
            $this->comments->update($comment);
        }
        // redisplay the post
        redirect('../../view/post/' . $postid);
    }

    function delete($cid) {
        $comment = $this->comments->get($cid);
        $postid = $comment->pid;
        $this->comments->delete($cid);
        //$this->index();
        redirect('../../view/post/' . $postid);
    }

}

/* End of file postcomment.php */
/* Location: ./system/application/controllers/postcomment.php */