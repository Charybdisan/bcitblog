<?php
if (!defined('APPPATH'))
    exit('No direct script access allowed');
?>

<!-- THE BLOG POST -->
<ul>
    <li>
        <div class="featured">
            <img src="/blog/data/images/{thumb}" alt=""/>
        </div>
        <div class="blogcontent">
            {buttons}
            <h3>{ptitle}</h3>
            <h4>{slug} ({pdate})</h4>
            <p>
                {story}
            </p>
        </div>

    </li>
</ul>
<!-- /THE BLOG POST -->

<!-- ADDING A COMMENT -->
<script type="text/javascript">
    var keynum, lines = 1;

    function limitLines(obj, e) {
        // IE
        if (window.event) {
            keynum = e.keyCode;
            // Netscape/Firefox/Opera
        } else if (e.which) {
            keynum = e.which;
        }

        if (keynum == 13) {
            if (lines == obj.rows) {
                return false;
            } else {
                lines++;
            }
        }
    }
</script>

<div class={allowed_add_comment}>
    <section class="ac-container">
        <div>
            <input id="ac-1" name="accordion-1" type="checkbox" />
            <label for="ac-1"><a id="comment"> Add a comment <span style="float:right;">(+)</span></a></label>
            <article class="ac-small-noscroll">
                <form action="/postcomment/submit/new" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="postid" value="{pid}"/>
                    <table>
                        <tr style="width:100%; height:100%;">
                            <td><textarea rows="4" cols="62" maxlength="200" class="textarea_comment" name="text" onkeydown="return limitLines(this, event)"></textarea></td>
                        </tr>
                        <tr>
                            <td><center>{fsubmitcomment}</center></td>
                        </tr>
                    </table>
                </form>
            </article>
        </div>
    </section>
</div>
<!-- /ADDING A COMMENT -->

<!-- VIEWING COMMENTS -->
<section class="ac-container">

    <input id="ac-2" name="accordion-1" type="checkbox" />
    <label for="ac-2">Comments ({numcomments}) <span style="float:right;"><a>(+)</a></span></label>

    <article class="ac-large">
        {comments}

        <span class="user_comment_author"><b>{author}</b></span> ({cdate}) {cmt_buttons}<br/>
        <div class="comment_text_view">
            {text}
        </div>
        {/comments}
    </article>
    <br/>
    <label><b>Posted By:</b> <span class="user_comment_author">{poster}</span> <span style="float:right;"><b>on:</b> <u>{pdate}</u></span></label>
    <label><b>Views:</b> {views}</label>
</section>
<!-- /VIEWING COMMENTS -->

<!-- SCORE AND RATING AND TAGS -->
<section class="ac-container">

    <div>
        <b>Score:</b> {score}<br/>
        <b>Rating:</b> {ratings}<br/>
    </div>
</section>
<div>
    <span class="tags">tags:
        {sep_tags}
        <a href="/blog/view/tag/{tag}">{tag}</a>
        {/sep_tags}
    </span>
</div>
<!-- /SCORE AND RATING AND TAGS -->