<?php 
    class ClientManager {
        public $errors;
        public $message;
        private $_tbl_name;
        private $_tbl_name_auth;
        private $_sql;
        private $_conn;
        public $client;
        public $file;
        public $login_info;
        public $newsLetter;
        


        function __construct() {

            $this->errors = [];
            $this->message = "";

            require 'NewsLetter.php';
            $this->newsLetter = new NewsLetter();

            require 'LoginPassword.php';
            $this->login_info = new LoginPassword();

            require 'Client.php';
            $this->client = new Client();
       
            require __DIR__.'\..\credentials.php';
            $this->_tbl_name_auth = $table_name_auth;
            $this->_tbl_name = $table_name;

            $this->_sql = "";

            $this->_conn = new mysqli($servername, $username, $password, $db_name);
            if ($this->_conn->connect_error) {
                $this->errors[] = "Connection failed: " . $this->_conn->connect_error;
                $this->hasErrors();
            }
        }
        
        function __destruct() {
            $this->_conn->close();
        }



        //===================================================================================== METHODS
        function show_msg () {
            echo "<h4 class='text-primary align-middle py-3'>$this->message</h4>";
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


//-----------------------------------------------------------------------------------------------
        function create_tbl(){
            $this->_sql = "CREATE TABLE $this->_tbl_name (
                id INT(6) AUTO_INCREMENT PRIMARY KEY,
                fname VARCHAR(30) NOT NULL,
                lname VARCHAR(30) NOT NULL,
                phone VARCHAR(12) ,
                email VARCHAR(30) NOT NULL,
                address_ VARCHAR(50) ,
                city VARCHAR(20) ,
                province VARCHAR(2) ,
                postal VARCHAR(7) ,
                dob DATE NOT NULL
                )";

            $this->_conn->query($this->_sql) ;
        }

//-----------------------------------------------------------------------------------------------
        function create_tbl_auth(){
            $this->_sql = "CREATE TABLE $this->_tbl_name_auth (
                id INT(2) AUTO_INCREMENT PRIMARY KEY,
                email VARCHAR(30) NOT NULL,
                hash VARCHAR(225) NOT NULL
                )";

            $this->_conn->query($this->_sql) ;
        }

//-----------------------------------------------------------------------------------------------
        function add_one_client(){

            if (!$this->client->hasErrors()){

                $stmt = $this->_conn->prepare("INSERT INTO $this->_tbl_name (fname, lname, phone, email, address_, city, province, postal, dob) VALUES (?,?,?,?,?,?,?,?,?)");
                $stmt->bind_param("sssssssss", $fname, $lname, $phone, $email, $address_, $city, $province, $postal, $dob);
                $fname = $this->client->get_fname();
                $lname = $this->client->get_lname();
                $phone = $this->client->get_phone();
                $email = $this->client->get_email();
                $address_ = $this->client->get_address();
                $city = $this->client->get_city();
                $province = $this->client->get_province();
                $postal = $this->client->get_postal();
                $dob = $this->client->get_dob();

                $stmt->execute();
                $this->client->reset_client();
                $this->message = "The record is added to database";
            }
        }


//-----------------------------------------------------------------------------------------------
        function get_client_from_POST () {

            $this->client->set_fname($_POST["fname"]);
            $this->client->set_lname($_POST["lname"]);
            $this->client->set_phone($_POST["phone"]);
            $this->client->set_email($_POST["email"]);
            $this->client->set_address($_POST["address"]);
            $this->client->set_city($_POST["city"]);
            $this->client->set_province($_POST["state"]);
            $this->client->set_postal($_POST["postal"]);
            $this->client->set_dob($_POST["dob"]);
            
        }
//-----------------------------------------------------------------------------------------------
        function get_client_from_ARRAY ($array) {

            $this->client->set_fname($array["0"]);
            $this->client->set_lname($array["1"]);
            $this->client->set_phone($array["2"]);
            $this->client->set_email($array["3"]);
            $this->client->set_address($array["4"]);
            $this->client->set_city($array["5"]);
            $this->client->set_province($array["6"]);
            $this->client->set_postal($array["7"]);
            $this->client->set_dob($array["8"]);

        }

//-----------------------------------------------------------------------------------------------
        function show_birthday_people () {
            $current_month = date("m");

            $this->_sql = "SELECT fname, lname, phone, email, address_, city, province, postal, dob from $this->_tbl_name WHERE MONTH(dob) = $current_month ORDER BY dob ASC; ";
            $result = $this->_conn->query($this->_sql);

            if (@$result->num_rows > 0) {

                require __DIR__.'\..\components\table_start.php';

                $row_number=1;
                while($row = $result->fetch_assoc()) {

                    echo "<tr>";
                    echo" <td scope='col'>$row_number</td>";

                    foreach ($row as &$value) {
                        echo" <td scope='col'>$value</td>";
                    }
                    echo "</tr>";
                    $row_number++;
                }
                echo "</tbody></table>";
            } else {
                $this->errors[] = "No records in database";
                $this->hasErrors();
            }
        }

//-----------------------------------------------------------------------------------------------
        function show_client_byID ($id_string) {

            $this->client->set_id($id_string);

            if (!$this->client->hasErrors()) {

                $stmt = $this->_conn->prepare("SELECT fname, lname, phone, email, address_, city, province, postal, dob from $this->_tbl_name WHERE id = ?") ;
                $stmt->bind_param("i", $id);
                $id = $this->client->get_id();
                $stmt->execute();
                $result = $stmt->get_result();
            
                require __DIR__.'\..\components\table_start.php';
            
                $row_number=1;
                while($row = $result->fetch_assoc()) {
            
                    echo "<tr>";
                    echo" <td scope='col'>$row_number</td>";
                    foreach ($row as &$value) {
                        echo" <td scope='col'>$value</td>";
                    }
                    echo "</tr>";
                    $row_number++;
                }
                echo "</tbody></table>";


            } else $this->message = "The record is added to database"; 
        }

//-----------------------------------------------------------------------------------------------
        function delete_by_ID ($string_id) {

            $this->client->set_id($string_id);

            if (!$this->client->hasErrors()) {

                $stmt = $this->_conn->prepare("DELETE FROM $this->_tbl_name WHERE id = ?") ;
        
                $stmt->bind_param("i", $id);
                $id = $this->client->get_id();
                $stmt->execute();
        
                $this->message = "The record is deleted";  
            }
        }

//-----------------------------------------------------------------------------------------------
        function get_client_by_ID ($string_id) {

            $this->client->set_id($string_id);

            if (!$this->client->hasErrors()) {
                    
                $stmt = $this->_conn->prepare("SELECT id, fname, lname, phone, email, address_, city, province, postal, dob from $this->_tbl_name WHERE id = ?") ;
                $stmt->bind_param("i", $id);
                $id = $this->client->get_id();
                $stmt->execute();
                $result = $stmt->get_result();
        
                $row = $result->fetch_assoc();

                return $row;

            } 
        }


//-----------------------------------------------------------------------------------------------
        function export_clients_db () {

            $this->_sql = "SELECT * FROM $this->_tbl_name";
            $result = $this->_conn->query($this->_sql);
           
            if ($result && $result->num_rows > 0) {

                if (!is_dir ( 'public' )) mkdir('./public/', 0777, true);

                $open = fopen("./public/export.csv", "w");

                while($row = $result->fetch_assoc()) {
                    $data = array(  $row["fname"], $row["lname"], $row["phone"], $row["email"], $row["address_"], $row["city"], $row["province"], $row["postal"],$row["dob"] );
                    fputcsv($open, $data);
                }

                fclose($open);

                $this->message = '<a href="./public/export.csv"><h4>Download</h4></a>';
                

            } else {
                $this->errors[] = "No records in database";
                $this->hasErrors();
            }
        }

//-----------------------------------------------------------------------------------------------
        function show_db() {
            $this->_sql = "SELECT id, fname, lname, phone, email, address_, city, province, postal, dob from $this->_tbl_name" ;
            $result = $this->_conn->query($this->_sql);

            if (@$result->num_rows > 0) {

                require __DIR__.'\..\components\table_start.php';

                while($row = $result->fetch_assoc()) {
                    $id = $row['id'];
                    echo "<tr>";

                    echo <<<BUTTONS
                    <td scope='col'>
                        <div class="btn-group btn-group-sm" role="group" >
                        <form action="delete.php" method="post">
                            <button type="submit" class="btn btn-outline-danger mx-2" name="delete" value="$id">Delete</button>
                        </form>
                        <form action="edit.php" method="post">
                            <button type="submit" class="btn btn-outline-success mx-2" name="edit" value="$id">Edit</button>
                        </form>
                        </div>
                    </td>
                    BUTTONS;

                    foreach ($row as $key => &$value) {
                        if ($key === "id") continue;
                        echo" <td scope='col'>$value</td>";
                    }

                    echo "</tr>";

                }
                echo "</tbody></table>";
            } else {
                $this->errors[] = "No records in database";
                $this->hasErrors();
            }
        }

//-----------------------------------------------------------------------------------------------
        function import_db_from_file ($post_file){

            require 'File.php';
            $this->file = new CSV_File($post_file);

            if (!$this->file->hasErrors()) {

                $stmt = $this->_conn->prepare("INSERT INTO $this->_tbl_name (fname, lname, phone, email, address_, city, province, postal, dob) VALUES (?,?,?,?,?,?,?,?,?)");
                $stmt->bind_param("sssssssss", $fname, $lname, $phone, $email, $address_, $city, $province, $postal, $dob);
                
                if (($open = fopen($this->file->safe_file(), "r")) !== FALSE) {
                    while (($data = fgetcsv($open, 1000, ",")) !== FALSE) {
                        if (count($data)>1){
                            $fname = $data["0"];
                            $lname = $data["1"];
                            $phone = $data["2"];
                            $email = $data["3"];
                            $address_ = $data["4"];
                            $city = $data["5"];
                            $province = $data['6'];
                            $postal = $data["7"];
                            $dob = $data['8'];

                            $stmt->execute();
                        }
                    }
                    fclose($open);
                }

                $this->message = "Database is imported";
            }
        }


//-----------------------------------------------------------------------------------------------
        function authenticate() {
            if(!$this->login_info->hasErrors()){
            
                $stmt = $this->_conn->prepare( "SELECT hash from $this->_tbl_name_auth WHERE email = (?)" );
                $stmt->bind_param("s", $email);
                $email = $this->login_info->get_email();
        
                $stmt->execute();
                $stmt->bind_result($retrieved_hash);
                $stmt->fetch();
                
                if (password_verify($this->login_info->get_password(), $retrieved_hash)) {
                    $_SESSION["authenticated"] = true;
                    header('Location: main.php');
                } else {
                    $this->errors[] = "No match found";
                    $this->hasErrors();
                }
            }
        }

//-----------------------------------------------------------------------------------------------
        function update_by_ID($string_id) {

            $this->client->set_id($string_id);

            if (!$this->client->hasErrors()){
              
                $stmt = $this->_conn->prepare("UPDATE $this->_tbl_name SET fname=?, lname=?, phone=?, email=?, address_=?, city=?, province=?, postal=?, dob=? WHERE id=?");
                $stmt->bind_param("sssssssssi", $fname, $lname, $phone, $email, $address_, $city, $province, $postal, $dob, $id);

                $fname = $this->client->get_fname();
                $lname = $this->client->get_lname();
                $phone = $this->client->get_phone();
                $email = $this->client->get_email();
                $address_ = $this->client->get_address();
                $city = $this->client->get_city();
                $province = $this->client->get_province();
                $postal = $this->client->get_postal();
                $dob = $this->client->get_dob();
                $id = $this->client->get_id();

                $stmt->execute();
                $this->client->reset_client();
                $this->message = "The record is modified successfully";
                return true;
            
            } else return false;
        }

//-----------------------------------------------------------------------------------------------
        function create_account () {

            if (!$this->login_info->hasErrors()){
                $hash = password_hash($this->login_info->get_password(), PASSWORD_DEFAULT);

                $stmt = $this->_conn->prepare( "INSERT INTO $this->_tbl_name_auth (email, hash) VALUES (?,?)" );
                $stmt->bind_param("ss", $email, $hash );
                $email = $this->login_info->get_email();

                $stmt->execute();
            }
        }

//-----------------------------------------------------------------------------------------------
        function send_news_letter(){

            if (!$this->newsLetter->hasErrors()){
                $this->_sql = "SELECT email from $this->_tbl_name" ;
                $result = $this->_conn->query($this->_sql);

                if (@$result->num_rows > 0) {

                    while($row = $result->fetch_assoc()) {
                   
                        $to_email = $row["email"];
                        $subject = $this->newsLetter->get_subject();
                        $message = $this->newsLetter->get_msg();
                        $headers = 'From: spivpracya@mail.ru';
                        mail($to_email,$subject,$message,$headers);
                         
                    }

                } else {
                    $this->errors[] = "The database is empty. Or an error occured";
                    $this->hasErrors();
                }
            }



        }




    } 
?>