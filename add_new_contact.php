<?php 
    session_start();
    if (!isset($_SESSION["authenticated"]) && $_SESSION["authenticated"] != true) {
        header('Location: index.php');
        exit;
    }
    require 'header.php';

    require 'navbar.php';
    navbar("Add new contact");
?>

<!-- //========================================================================================== HTML FORM -->




<?php 
    require 'add_edit_form.php'; 
    add_edit_form();
?>

<?php require 'header.php'; ?>



<!-- ========================================================================================== BACK END -->


<?php 
    
    $error = [];

    function test_input($data) {
        if (empty($data))  {
            global $error;
            $error[] = "empty";
        }

        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);

        return $data;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])){
        $fname = test_input($_POST["fname"]);
        $lname = test_input($_POST["lname"]);
        $phone = test_input($_POST["phone"]);
        $email = test_input($_POST["email"]);
        $address_ = test_input($_POST["address"]);
        $city = test_input($_POST["city"]);
        $province = test_input($_POST["state"]);
        $postal = test_input($_POST["postal"]);
        $dob = test_input($_POST["dob"]);

    }

    require 'credentials.php';


    //=================================================================== add a client record

    if ((isset($_POST["submit"]))){

        if (count($error) == 0){

            $conn = new mysqli($servername, $username, $password, $db_name);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }



            
            
            //create table
            $sql = "CREATE TABLE tbl_clients (
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

            if ($conn->query($sql) === TRUE) {
                echo "Table created successfully";
            } 

                    




            $stmt = $conn->prepare("INSERT INTO tbl_clients (fname, lname, phone, email, address_, city, province, postal, dob) VALUES (?,?,?,?,?,?,?,?,?)");
            $stmt->bind_param("sssssssss", $fname, $lname, $phone, $email, $address_, $city, $province, $postal, $dob);
            
            $stmt->execute();
            
            $conn->close();

            echo "<h4>The record is added</h4>";
        } else {
            echo "<h4>Check Fields";
        }
    }


?>