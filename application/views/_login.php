<?php
/**
 * View fragment to hold login form
 */
?>
<div class="login_form" style="position: relative; left: -175px; top: -8px;">  
            <table style="position: relative; top: -5px;">
                <form method="post" action="/blog/login/submit"> 
                <tr>
                    <td>{fid}</td>
                    <td>{fpassword}</td>
                    <td style="padding-top: 15px;">{fsubmit}</td>
                    <td><div class="cust_bogus_comment">{fcomment}</div></td>
                </tr>
                </form>
            </table>
</div>

<!-- INSIDE

    <form method="post" action="/login/submit" style="position: relative;"> 
        <table style="position: relative; top: -5px;">
            <tr>
                <td>{fid}</td>
                <td>{fpassword}</td>
                <td class="login_button">{fsubmit}</td>
            </tr>
        </table>
        <div class="cust_bogus_comment">{fcomment}</div>
    </form>

-->