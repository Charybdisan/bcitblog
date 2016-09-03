    <script type="text/javascript">
      var keynum, lines = 1;

      function limitLines(obj, e) {
        // IE
        if(window.event) {
          keynum = e.keyCode;
        // Netscape/Firefox/Opera
        } else if(e.which) {
          keynum = e.which;
        }

        if(keynum == 13) {
          if(lines == obj.rows) {
            return false;
          }else{
            lines++;
          }
        }
      }
      </script>
<h3>Editing comment of user: <a href="#">{c_user}</a></h1>
<div style="width: 250px">
    <form action="/blog/postcomment/submit/{id}" method="post">
        <input type="hidden" name="postid" value="{postid}"/>
        <textarea rows="4" cols="62" maxlength="200" class="textarea_comment" name="text" onkeydown="return limitLines(this, event)">{c_text}</textarea>
        <br/><br/>
        {fsubmit}
        {fcancel}
    </form>
</div>
