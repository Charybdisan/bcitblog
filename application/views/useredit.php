<?php
if (!defined('APPPATH'))
    exit('No direct script access allowed');
/**
 * views/useredit.php
 *
 * Manage member settings
 *
 * @author		JLP
 * ------------------------------------------------------------------------
 */
/*if (isset($this->data['errors']) && count($this->data['errors']) > 0) {
    $errors = $this->data['errors'];
    echo"<div class='alert alert-error'>";
        echo "<p><strong></strong></p>";
        foreach ($errors as $booboo)
            echo '<p>' . $booboo . '</p>';
    echo '</div>';
}
 */
?>
{errors}
<form action="/blog/usermtce/submit/{id}" method="post">
    {fid}
    {fname}
    {fpassword}
    {frole}
    {femail}
    {flastvisit}
    {fstatus}
    <br/><br/>
    {fsubmit}
    {fcancel}
</form>

    <!--
    <label for="id">Userid</label>
    <input type="text" name="id" id="id" value="{id}" />
    <label for="name">User Name</label>
    <input type="text" name="name" id="name" value="{name}" />
    <label for="name">Password (plaintext; if changed)</label>
    <input type="text" name="password" id="password" value="{password}" />
    <label for="name">Role</label>
    <input type="text" name="role" id="role" value="{role}" />
    <label for="name">Email Address</label>
    <input type="text" name="email" id="email" value="{email}" />
    <label for="name">Date last visited (yyyy-mm-dd)</label>
    <input type="text" name="lastvisit" id="lastvisit" value="{lastvisit}" />
    <label for="name">Status (A for active)</label>
    <input type="text" name="status" id="status" value="{status}" />
    <br/><br/>
    <button type="submit">Submit</button>     
    <a href="/usermtce"><input type="button" value="Cancel"></input></a>
    -->
</form>

