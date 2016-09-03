<?php

/*
 * View fragment for a user that is all ready logged in
 */
?>

<div class="login_form" style="position: relative; left: -175px; top: -8px;">
        <table style="position: relative; top: -5px;">
            <tr>
                <td>
                 Hi, {userName} ({userRole})
                 <br/>
                 {admin_menu}
                </td>
            </tr>
            <tr>
                <td>
                {flogout}
                <!--<button onclick="window.location.href = '/logout';">Logout</button>-->
                </td>
            </tr>
        </table>
</div>