<h1>Add a post</h1>

<script type="text/javascript" src="/blog/assets/js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
tinyMCE.init({
        mode  :  "textareas",
        theme :  "simple",    //(n.b. no trailing comma, this will be critical as you experiment later)
        height:  100,
        width :  320
});
</script>

<form action="/blog/postmtce/submitpost/new" method="post" enctype="multipart/form-data">
    <label>Select a thumbnail image for your post</label>
    <input type="file" id="upload" name="upload" accept="image/*">
    <p/>
    {ftitle}
    {fslug}
    <div class="control-group">
        <textarea rows="3" id="text" class="" name="text" placeholder="Text"></textarea>
    </div>
    {ftags}
    <div class="control-group">
        {fsubmit}
    </div>
</form>