<?php

if (!defined('APPPATH'))
    exit('No direct script access allowed');

/**
 * helpers/common_helper.php
 *
 * Functions extracted through refactoring
 *
 * @package		GICC Backend
 * @author		JLP
 * @copyright           Copyright (c) 2009-2013, Galiano Island Chamber of Commerce
 * @since		Version 3.15
 * Updated              v3.18.6: Added extractChanges method
 * Updated              v3.18.6: Switch text/html properties - we need text for mailouts,
 *                          html for all others
 * Updated              v4.0.0: Port to CI2.0
 * ------------------------------------------------------------------------
 */
//-------------------------------------------------------------------------
//  Object/array manipulation

/**
 * Extract cells from an array into corresponding properties in an object
 * @param array $source
 * @param object $target
 * @param array $fields 
 */
function fieldExtract($source, $target, $fields) {
    foreach ($fields as $prop) {
        if (isset($source[$prop])) {
            $target->$prop = html_entity_decode($source[$prop]);
        }
    }
}

/**
 * Inject cells into an array from corresponding properties in an object
 * @param <type> $source
 * @param <type> $target
 * @param <type> $fields 
 */
function fieldInject($source, &$target, $fields) {
    foreach ($fields as $prop) {
        if (isset($source->$prop)) {
//            $target[$prop] = html_entity_encode($source->$prop);
            $target[$prop] = $source->$prop;
        }
    }
}

/**
 * Identify any changed fields and build the body of an email message for membership@
 * @param <type> $source
 * @param <type> $target
 * @param <type> $fields
 * @param <type> $changes
 * @return string 
 */
function extractChanges($source, $target, $fields, $changes) {
    foreach ($fields as $prop) {
        if (isset($source[$prop])) {
            if ($source[$prop] != $target->$prop) {
                $changes[] = "Field: " . $prop;
                $changes[] = "Old value: " . $target->$prop;
                $changes[] = "New value: " . $source[$prop];
                $changes[] = "";
            }
        }
    }
    return $changes;
}

/**
 * Extract properties from an object
 * @param <type> $source
 * @param <type> $fields
 * @param <type> $changes
 * @return string 
 */
function extractFields($source, $fields, $changes) {
    foreach ($fields as $prop) {
        if (isset($source->$prop)) {
            $changes[] = $prop . ": ";
            $changes[] = $source->$prop;
        }
    }
    return $changes;
}

/**
 * Collapse an array of strings into a single string, with breaks
 * @param <type> $what
 * @return string 
 */
function collapseArray($what) {
    $result = "";
    foreach ($what as $one) {
        $result .= $one . "<br/>";
    }
    return $result;
}

/**
 *  Send an email.
 * 
 * Email parameters in an array parm ...
 * from     => email address of sender
 * to       => email address(es) of receipient
 * cc       => email address(es) to copy
 * bcc      => email address(es) to blind copy
 * subject  => subject line
 * template => name of template to use for the body
 * signature => name of template to use for the signature
 * 
 * @param <type> $parms     The email parameters
 * @param array $data       The database etc data we are going to run through the template
 */
function sendMail($parms, $data) {
    $CI = &get_instance();
    $CI->load->library('email');   // go get the email helper
    // prime the email helper object
    $props = array();
    $props['protocol'] = 'sendmail';
    $props['mailtype'] = 'html';    // force the email type to be HTML
    $CI->email->initialize($props);

    // Set the email header stuff
    $CI->email->from($parms['from']);
    $CI->email->to($parms['to']);
    if (isset($parms['cc']))
        $CI->email->cc($parms['cc']);
    if (isset($parms['bcc']))
        $CI->email->bcc($parms['bcc']);
    $CI->email->subject($parms['subject']);

    // Now for the body!
    $CI->load->library('parser');     // get the template helper
    $data['date'] = date(DATE_FORMAT);  // add in the current date, just in case
    // Apply a template to the data, if we have one
    if (isset($parms['template']))
        $message = $CI->parser->parse($parms['template'], $data, true);
    else
        $message = $data;  // or else use the data as is, whatever it might be

    $CI->email->message($message);    // set this as the email body
    $CI->email->send();    // and off to the post office :)
}

/**
 * Email preview.
 * Same parameters as sendMail, but nothing is sent - we are just extracting
 * the email contents, as HTML
 * @param <type> $obj
 * @param <type> $parms
 * @param array $data
 * @return <type> 
 */
function peekMail($obj, $parms, $data) {
    $obj->load->library('email');   // go get the email helper
    $this->load->library('parser');     // get the template helper
    $data['date'] = date(DATE_FORMAT);  // add in the current date, just in case
// Apply a template to the data, if we have one
    if (isset($parms['template']))
        $message = $this->parser->parse($parms['template'], $data, true);
    else
        $message = $data;  // or else use the data as is, whatever it might be
// Apply a signature, if we have one
    if (isset($parms['signature']))
        $message .= $this->parser->parse($parms['signature'], $data, true);
    return $message;        // What did we end up with??
}

/**
 * Determine the difference between two days.
 * Needed for PHP < 5.3
 * 
 * @param type $date1 First date (older)
 * @param type $date2 Second date (newer)
 * @return int $ of days between them
 */
if (!function_exists('date_diff')) {

    function date_diff($date1, $date2 = null) {
        if ($date2 == null)
            $date2 = date(DATE_FORMAT);
        $start_date = new DateTime($date1);
        $end_date = new DateTime($date2);

        if (PHP_VERSION >= "5.3")
            $elapsed = $start_date->diff($end_date);
        else
            $elapsed = ($end_date->format('U') - $start_date->format('U')) / SECONDS_PER_DAY;

        return $elapsed;
    }

}

/* End of file */
