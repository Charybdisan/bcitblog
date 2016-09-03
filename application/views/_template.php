<?php
if (!defined('APPPATH'))
    exit('No direct script access allowed');
/**
 * view/template.php
 *
 * Pass in $pagetitle (which will in turn be passed along)
 * and $pagebody, the name of the content view.
 *
 * ------------------------------------------------------------------------
 */
//{menubar}
//{content}
//
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!-- Website template by freewebsitetemplates.com -->
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>{title}</title>
        <link rel="stylesheet" type="text/css" href="/blog/assets/css/bootstrap.min.css" media="screen"/>
        <link rel="stylesheet" type="text/css" href="/blog/assets/css/style.css"/>
        <link rel="stylesheet" type="text/css" href="/blog/assets/css/bootstrap-responsive.min.css"/>
        
        <link rel="stylesheet" type="text/css" href="/blog/assets/css/accordian.css">

                {caboose_styles}
                <!--[if IE 7]>
                        <link rel="stylesheet" href="assets/css/ie7.css" type="text/css" />
                <![endif]-->
                </head>
                <body>
                    <div class="page">
                        <div class="header">
                            <a href="/blog" id="logo"><img src="/blog/assets/images/logo.gif" alt=""/></a>
                            <div style="position: relative; left:200px;">{login_form}</div>
                            {menubar}  
                        </div>
                        <div class="body">
                            {content}
                        </div>
                    </div>                    
                    <div class="footer">
                        {menubar}
                        <p>Made with CodeIgniter. Copyright &#169; 2014 Taylor Lino</p> 
                    </div>
                    <script src="/blog/assets/js/jquery.min.js"></script>
                    <script src="/blog/assets/js/bootstrap.min.js"></script>
                    {caboose_scripts}
                    {caboose_trailings}
                </body>
                </html>  