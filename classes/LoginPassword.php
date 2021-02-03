<?php 
    class LoginPassword {
        public $errors;
        private $_email;
        private $_password;
  

        function __construct() {

            $this->errors = [];
            $this->_email = "";
            $this->_password = "";

        }

        //================================================= GET / SET
        function get_email() {
            return $this->_email;
        }

        function get_password() {
            return $this->_password;
        }

        function set_email($string) {
            if (empty($string))  {
                return $this->errors[] = "No email provided";
            }
            if (filter_var ($this->validate($string), FILTER_VALIDATE_EMAIL)) {
                $this->_email = filter_var ($this->validate($string), FILTER_VALIDATE_EMAIL);   
            } else return $this->errors[] = "wrong email format";
        }

        function set_password($string) {
            if (empty($string))  {
                return $this->errors[] = "Password is not set";
            }
            $this->_password = $this->validate($string);  
        }

        
        //================================================= METHODS
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
                exit;
            } 
            else return false;
        }








    }
?>