<?php 
    class Client {
        public $errors;
        private $_id;
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
            $this->_id=0;
            $this->errors = [];
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
        function get_id() {
            return $this->_id;
        }
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
        function set_id($string) {
            if (empty($string))  {
                return $this->errors[] = "ID is not declared";
            }
            if (preg_match('/^[0-9]{1,2}$/', $string) === 0) return $this->errors[] = "ID has wrong format";
            $this->_id = $this->validate($string);  
        }

        function set_fname($string) {
            if (empty($string))  {
                return $this->errors[] = "First name is not declared";
            }
            $this->_fname = $this->validate($string);  
        }

        function set_lname($string) {
            if (empty($string))  {
                return $this->errors[] = "Last name is not declared";
            }
            $this->_lname = $this->validate($string);  
        }

        function set_email($string) {
            if (empty($string))  {
                return $this->errors[] = "Email is not declared";
            }
            if (filter_var ($this->validate($string), FILTER_VALIDATE_EMAIL)) {
                $this->_email = filter_var ($this->validate($string), FILTER_VALIDATE_EMAIL);   
            } else return $this->errors[] = "wrong email format";
 
        }

        function set_phone($string) {
            if (empty($string))  {
                return $this->errors[] = "Phone number is not declared";
            }
            $this->_phone = $this->validate($string);  
        }

        function set_address($string) {
            if (empty($string))  {
                return $this->errors[] = "Address is not declared";
            }
            $this->_address = $this->validate($string);  
        }

        function set_city($string) {
            if (empty($string))  {
                return $this->errors[] = "City is not declared";
            }
            $this->_city = $this->validate($string);  
        }

        function set_province($string) {
            if (empty($string))  {
                return $this->$errors[] = "Province is not declared";
            }
            if (preg_match('/^[a-zA-Z]{2}$/i', $string) === 0) return $this->errors[] = "Province has wrong format";
            $this->_province = $this->validate($string);  
        }

        function set_postal($string) {
            if (empty($string))  {
                return $this->errors[] = "Postal code is not declared";
            }
            if (preg_match('/^[a-zA-Z][0-9][a-zA-Z]\s{0,1}[0-9][a-zA-Z][0-9]$/i', $string) === 0) return $this->errors[] = "Postal code has wrong format";
            $this->_postal = $this->validate($string);  
        }

        function set_dob($string) {
            if (empty($string))  {
                return $this->errors[] = "Date of Birth is not declared";
            }
            if (preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/i', $string) === 0) return $this->errors[] = "Date has wrong format";
            $this->_dob = $this->validate($string);  
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
                return true;
            } 
            else return false;
        }


        function reset_client(){
            $this->_id=0;
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

        function get_client_array() {
            return array(
                'fname' => $this->_fname,
                'lname' => $this->_lname,
                'email' => $this->_email,
                'phone' =>  $this->_phone,
                'address_' => $this->_address,
                'city' =>  $this->_city,
                'province' => $this->_province,
                'postal' => $this->_postal,
                'dob' => $this->_dob,
                'id' => $this->_id
            );
        }

    }
?>