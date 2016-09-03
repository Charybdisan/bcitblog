<?php
class Errormake extends _Mymodel {
    // Constructor
    function __construct() {
    parent::__construct();
    }
    
    function build_errors($error_title, $errors){
            $parsedErrors = array();
            $data = array();
            $ind = 0;
            foreach ($errors as $error) {
               $ind++;
               $parsedErrors[] = array(
                   'num' => $ind,
                   'error' => $error
                       );   
            }
            
            $data = array(
                'errortitle' => $error_title,
                'errors' => $parsedErrors
            );
            
            return $this->parser->parse('error_report', $data, true);
         
    }
}
?>