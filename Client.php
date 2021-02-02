<?php 
    class Client {
        public $error_array;
        private $_fname;
        private $_lname;
        private $_email;
        private $_phone;
        private $_address;
        private $_city;
        private $_province;
        private $_postal;
        private $_dob;

        function __construct() {
            $this->error_array = [];
            $this->_fname = "";
            $this->_lname = "";
            $this->_email = "";
            $this->_phone = "";
            $this->_address = "";
            $this->_city = "";
            $this->_province = "";
            $this->_postal = "";
            $this->_dob = "";
        }
    //================================================= GET
        function get_fname() {
            return $this->_fname;
        }
        function get_lname() {
            return $this->_lname;
        }
        function get_email() {
            return $this->_email;
        }
        function get_phone() {
            return $this->_phone;
        }
        function get_address() {
            return $this->_address;
        }
        function get_city() {
            return $this->_city;
        }
        function get_province() {
            return $this->_province;
        }
        function get_postal() {
            return $this->_postal;
        }
        function get_dob() {
            return $this->_dob;
        }

        //================================================= SET
        function set_fname($string) {
            if (empty($string))  {
                return $this->$error_array[] = "First name is not declared";
            }
            $this->_fname = validate($string);  
        }

        function set_lname($string) {
            if (empty($string))  {
                return $this->$error_array[] = "Last name is not declared";
            }
            $this->_lname = validate($string);  
        }

        function set_email($string) {
            if (empty($string))  {
                return $this->$error_array[] = "Email is not declared";
            }
            $this->_email = filter_var (validate($string), FILTER_VALIDATE_EMAIL);  
        }

        function set_phone($string) {
            if (empty($string))  {
                return $this->$error_array[] = "Phone number is not declared";
            }
            $this->_phone = validate($string);  
        }

        function set_address($string) {
            if (empty($string))  {
                return $this->$error_array[] = "Address is not declared";
            }
            $this->_address = validate($string);  
        }

        function set_city($string) {
            if (empty($string))  {
                return $this->$error_array[] = "City is not declared";
            }
            $this->_city = validate($string);  
        }

        function set_province($string) {
            if (empty($string))  {
                return $this->$error_array[] = "Province is not declared";
            }
            if (preg_match('/^[a-zA-Z]{2}$/i', $string) === 0) return $this->$error_array[] = "Province has wrong format";
            $this->_province = validate($string);  
        }

        function set_postal($string) {
            if (empty($string))  {
                return $this->$error_array[] = "Postal code is not declared";
            }
            if (preg_match('/^[a-zA-Z][0-9][a-zA-Z]\s{0,1}[0-9][a-zA-Z][0-9]$/i', $string) === 0) return $this->$error_array[] = "Postal code has wrong format";
            $this->_postal = validate($string);  
        }

        function set_dob($string) {
            if (empty($string))  {
                return $this->$error_array[] = "Date of Birth is not declared";
            }
            if (preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/i', $string) === 0) return $this->$error_array[] = "Date has wrong format";
            $this->_dob = validate($string);  
        }



        //================================================= METHODS
        function validate($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            if ($data = filter_var($data, FILTER_SANITIZE_STRING)) return $data;
        }
    }
?>