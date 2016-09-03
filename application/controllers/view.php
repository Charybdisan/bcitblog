<?php
/**
 * Our blog page.
 * 
 * controllers/blog.php
 *
 * ------------------------------------------------------------------------
 */
class View extends Application {

    function __construct() {
        parent::__construct();
    }

    //-------------------------------------------------------------
    //  The normal pages
    //-------------------------------------------------------------

    function index() {
        $this->showPosts();
    }

    function tag($tag) {
        $this->showPosts($tag);
    }

    function showPosts($tag = null) {
        $this->data['title'] = 'Blog';
        $this->data['pagebody'] = 'blog';
        $this->data['jump'] = '';
        if ($tag == null) {
            $records = $this->posts->getAll_array_reversed();
        } else {
            $this->data['jump'] = '../../';
            $temp_records = $this->posts->getAll_array_reversed();
            $records = array();
            foreach ($temp_records as $temp_record) {
                $temp_tags = explode(" ", $temp_record['tags']);
                foreach ($temp_tags as $temp_tag) {
                    if ($temp_tag == $tag) {
                        $records[] = $temp_record;
                    }
                }
            }
        }
        $postNum = count($records);
        foreach ($records as &$record) {
            $record['postNum'] = $postNum;
            $temp_tags = explode(" ", $record['tags']);
            $record['sep_tags'] = array();
            foreach ($temp_tags as $tag) {
                $newtag = array();
                $newtag['tag'] = $tag;
                $record['sep_tags'][$tag] = $newtag;
            }
            $record = $this->massage($record);
            $postNum-=1;
        }
        $this->data['posts'] = $records;
        if ($this->session->userdata('userRole') == 'admin') {
            $this->data['addpost'] = makeLinkButton('Add Post', '/blog/postmtce/add', 'Add a new post to the blog');
        } else {
            $this->data['addpost'] = "";
        }
        $this->render();
    }

    // Present a single post.
    // For now, this is being a bit faked.
    function post($which) {
        // get the post
        $record = (array) $this->posts->get($which);
        $record = $this->massage($record);
        $postId = $record['uid'];
        $this->data['pid'] = $postId;
        $record = $this->massage($record);
        $this->data = array_merge($this->data, $record);

        $record['ptitle'] = htmlentities($record['ptitle']);
        $record['slug'] = htmlentities($record['slug']);
        $record['story'] = htmlentities($record['story']);
        
        //The TAGS
        $temp_tags = explode(" ", $record['tags']);
        $this->data['sep_tags'] = array();
        foreach ($temp_tags as $tag) {
            $newtag = array();
            $newtag['tag'] = strip_tags($tag);//htmlspecialchars(htmlentities($tag), 3);
            $this->data['sep_tags'][$tag] = $newtag;
        }
        $record = $this->massage($record);


        // get any media associated with it
        //$media = $this->media->querySomeMore('uid', $which);
        $thumb = $record['thumb'];
        $this->data['thumb'] = $thumb;
        //$this->data['media'] = $media;
        $this->data['fsubmitcomment'] = makeSubmitButton('Submit', 'Come on, go for it!');
        $postDate = $record['pdate'];
        $this->data['pdate'] = $postDate;

        $this->data['views'] = $record['views'];
        $this->data['score'] = $record['score'];
        $this->data['ratings'] = $record['ratings'];
        $this->data['poster'] = $record['poster'];

        // and light up the page
        $this->data['title'] = "Post: " . $record['ptitle'];
        //"Post #" . $record['uid'] . ' ' . $record['ptitle'];
        $this->data['pagebody'] = 'blogpost';


        $comments = $this->comments->getAll_array_value_reversed("pid", $postId);
        foreach ($comments as &$com) {
            $com['text'] = nl2br_limit(htmlspecialchars($com['text']), 3);
        }
        $this->data['numcomments'] = count($comments);


        foreach ($comments as &$comment) {
            $comment = $this->massage_comment($comment);
        }
        $this->data['comments'] = $comments;

        $this->data['allowed_add_comment'] = '';

        if (!$this->session->userdata('userID')) {
            $this->data['allowed_add_comment'] = 'hide';
        }

        $this->render();
    }

    // Massage a post record, adding role-restricted buttons
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

    // Massage a post record, adding role-restricted buttons
    function massage_comment($comment) {
        $comment['cmt_buttons'] = '';
        $sesid = $this->session->userdata('userID');
        if ($sesid) {
            if (($this->session->userdata('userRole') == 'admin') || ($sesid == $comment['author'])) {
                $comment['cmt_buttons'] .= $this->parser->parse('_comment_mtce_buttons', $comment, true);
            }
            /*
              //Allow a user to delete his/her own comment
              if ($this->session->userdata('userRole') == 'user'){
              //$record['buttons'] .= $this->parser->parse('_comment_buttons', $record, true);
              }
             */
        }
        return $comment;
    }

}

/* End of file blog.php */
/* Location: application/controllers/blog.php */