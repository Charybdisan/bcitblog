<?php
if (!defined('APPPATH'))
    exit('No direct script access allowed');
/**
 * views/admin.php
 *
 * Manage syndication settings
 *
 * @author		JLP
 * ------------------------------------------------------------------------
 */
?>
<h1>Syndication Configuration</h1>
<!--{ferror_messages}-->
<form action="/blog/administer/submit" method="post">
    {fcode}
    {fname}
    {flink}
    {fslug}
    {fboss}
    {fport}
    <br/><br/>
    {fsubmit}
    {fcancel}
</form>

