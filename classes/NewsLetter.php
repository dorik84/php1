<?php 
    class NewsLetter {
        public $errors;
        private $_subject;
        private $_msg;
       

        function __construct() {
    
            $this->errors = [];
            $this->_subjectrs = "";
            $this->_msg = "";
        }
    //================================================= GET
        function get_subject() {
            return $this->_subject;
        }
        function get_msg() {
            return $this->_msg;
        }
       
        //================================================= SET
        function set_subject($string) {
            if (empty($string))  {
                return $this->errors[] = "Subject is not declared";
            }
            $this->_subject = $this->validate($string);  
        }

        function set_msg($string) {
            if (empty($string))  {
                return $this->errors[] = "Message is not declared";
            }
            $this->_msg = $this->validate($string);  
        }


        //================================================= PRIVATE METHODS
        function validate($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            if ($data = filter_var($data, FILTER_SANITIZE_STRING)) return $data;
        }

        function hasErrors() {
            if ( count($this->errors) > 0){
                echo '<ul>';
                foreach($this->errors as $value) {
                    echo "<li style='color:red;'>$value</li>";
                }
                echo '</ul>';
                return true;
            } 
            else return false;
        }

    }
?>