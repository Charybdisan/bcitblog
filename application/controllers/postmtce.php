<?php

/**
 * controllers/postmtce.php
 *
 * Posting table maintenance
 *
 * @package		Java-Geeks
 * @author		JLP
 * @copyright           Copyright (c) 2013, J.L. Parry
 * @since		Version 2.0.0
 * ------------------------------------------------------------------------
 */
class Postmtce extends Application {

    function __construct() {
        parent::__construct();
        $this->restrict(ROLE_ADMIN);
        $this->load->model('errormake');
    }

    //-------------------------------------------------------------
    //  The index should never be called!
    //-------------------------------------------------------------

    function index() {
        redirect('/blog/view');
    }

    //-------------------------------------------------------------
    //  Trigger adding a new post
    //-------------------------------------------------------------

    function add() {
        $this->data['title'] = "Add a Posting";
        $posting = (array) $this->posts->create();
        $this->data = array_merge($this->data, $posting);
        $this->data['id'] = 'new';
        $this->data['pagebody'] = 'postadd';
        $this->data['ftitle'] = makeTextField('Post Title', 'ptitle', '');
        $this->data['fslug'] = makeTextField('Slug', 'slug', '');
        $this->data['ftags'] = makeTextField('Tags (separate tags with spaces)', 'tags', '');
        $this->data['fsubmit'] = makeSubmitButton_ImageUpload('Submit', 'Away we go');
        $this->data['fcancel'] = makeLinkButton('Cancel', '/blog/view', 'Forget about it');
        $this->render();
    }

    // Request a post edit
    function edit($id) {
        $this->data['title'] = "Edit a Posting";
        $posting = (array) $this->posts->get($id);
        //var_dump($posting);
        //die();
        $this->data = array_merge($this->data, $posting);
        $this->data['id'] = $id;
        $this->data['pagebody'] = 'postedit';
        $this->data['thumb'] = $posting['thumb'];
        $this->data['ftitle'] = makeTextField('Post Title', 'ptitle', $posting['ptitle']);
        //No need to edit the date of a post
        //$this->data['fdate'] = $posting['pdate'];
        $this->data['fslug'] = makeTextField('Slug', 'slug', $posting['slug']);
        $this->data['ftags'] = makeTextField('Tags (separate tags with spaces)', 'tags', $posting['tags']);
        $this->data['fstory'] = $posting['story'];
        $this->data['fsubmit'] = makeSubmitButton_ImageUpload('Submit', 'Away we go');
        $this->data['fcancel'] = makeLinkButton('Cancel', '/blog/view/post/' . $id, 'Forget about it');
        
        $this->render();
    }

    // Delete a posting (and all associated comments)
    function delete($id) {
        $associatedComments = (array)$this->comments->getAll_table_array_value_reversed('comments', 'pid', $id);
        foreach($associatedComments as $comment){
            $this->comments->delete($comment['cid']);
        }
        $this->posts->delete($id);
        redirect('../../view');
        //redirect('./view');
        //$this->index();
    }
    
    function submitpost($which){
        if($which == null || $which == "new") {
            $action = "add";
            $posting = $this->posts->create();
        }
        else {
            $action = "edit";
            $posting = (array) $this->posts->get($which);
        }
        
        $okToHaveBlankImage = false;
        if($action == "edit")
            $okToHaveBlankImage = true;
        
        $errors = array();
        
        if(isset($_FILES['upload']['tmp_name'])){
            if($_FILES['upload']['name'] == "" && $action == "add")
                $errors[0] = 'You need to upload a thumbnail for your post.';
        }        
        if($_POST['ptitle'] == "")
            $errors[1] = 'You need a title for your post.';
        if($_POST['slug'] == "")
            $errors[2] = 'You need a slug for your post.';
        if (!preg_match('/^[a-z0-9_\s]+$/i', $_POST['tags']))
            $errors[3] = 'You have illegal characters in your tags.';
        if (count($errors) > 0) {
            $this->data['pagebody'] = 'errors';
            $this->data['title'] = "Error";
            
            $error_title = "Post Maintenance | (" . "edit" . ")";
            $this->data['showerrors'] = $this->errormake->build_errors($error_title, $errors);
            
            $theAction = $action . "/";
            if($action == "edit"){
                $theAction = $action . "/" . $which . "/";
            }
            
            
            $this->data['goback'] = makeLinkButton('Go Back', '/blog/postmtce/' . $theAction, 'Go back to previous page');
            $this->render();
            return;
        }
        
        $moved = false;
        $isBlank = true;
        if($_FILES['upload']['name'] != ""){
            $isBlank = false;
            $fileName =  $_FILES['upload']['name'];
            $fileName =  preg_replace("/\\.[^.\\s]{3,4}$/", "", $fileName);
            $fileName.=  generateRandomString(15);
            $fileTmp = $_FILES['upload']['tmp_name'];
            $trueName = "blog_" . $fileName;
            $target = IMAGEDATA_FOLDER . $trueName ;
            $moved = move_uploaded_file($fileTmp, $target);
        }
        
        
        if($moved || $okToHaveBlankImage){
            //No errors, add/edit post!
            if($action == "add"){
                $posting->thumb = $trueName;
                $posting->ptitle = htmlentities($_POST['ptitle']);
                $posting->pdate = date(DATE_FORMAT);
                $posting->tags = htmlentities($_POST['tags']);
                $posting->slug = htmlentities($_POST['slug']);
                $posting->story = $_POST['text'];
                $thePoster = (string) $this->session->userdata('userID');
                $posting->poster = $thePoster;
                $posting->views = 0;
                $posting->score = 0;
                $posting->ratings = 0;
                
                $this->posts->add($posting);
                $postId = $this->db->insert_id();
                redirect('../../view/post/' . $postId);
            }
            else if($action == "edit"){
                if(!$isBlank)
                    $posting['thumb'] = $trueName;
                $posting['ptitle'] = htmlentities($_POST['ptitle']);
                $posting['pdate'] = htmlentities(date("Y.m.d"));
                $posting['tags'] = htmlentities($_POST['tags']);
                $posting['slug'] = htmlentities($_POST['slug']);
                $posting['story'] = $_POST['text'];
                
                $this->posts->update($posting);
                redirect('../../view/post/' . $which);
            }            
        }        
    }

}

/* End of file postmtce.php */
/* Location: ./system/application/controllers/postmtce.php */