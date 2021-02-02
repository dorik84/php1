<?php 
    session_start();

    if (!isset($_SESSION["authenticated"]) && !$_SESSION["authenticated"] == true) {
        header('Location: index.php');
        exit;
    }

    require 'header.php';
    require 'navbar.php';
    navbar("All contacts");




//================================================================ create form and populate it

if (isset($_POST["edit"]) && $_POST["edit"] != 0){
    require 'credentials.php';

    $conn = new mysqli($servername, $username, $password, $db_name);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
        
    $stmt = $conn->prepare("SELECT id, fname, lname, phone, email, address_, city, province, postal, dob from $table_name WHERE id = ?") ;
    $stmt->bind_param("i", $id);
    $id = $_POST["edit"];
    $stmt->execute();
    $result = $stmt->get_result();



    echo "<h4>Edit contact:</h4>";


    while($row = $result->fetch_assoc()) {

        require 'add_edit_form.php'; 
        add_edit_form($row['fname'], $row['lname'], $row['email'], $row['phone'], $row['address_'], $row['city'], $row['province'], $row['postal'], $row['dob'], $row['id'] );

    }
    $conn->close();

}




    //======================================check and edit data
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
        $id = test_input($_POST["submit"]);
    }

    require 'credentials.php';


    //=================================================================== add a client record

    if ((isset($_POST["submit"]))){

        if (count($error) == 0){

            $conn = new mysqli($servername, $username, $password, $db_name);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

  
            $stmt = $conn->prepare("UPDATE $table_name SET fname=?, lname=?, phone=?, email=?, address_=?, city=?, province=?, postal=?, dob=? WHERE id=?");
            $stmt->bind_param("sssssssssi", $fname, $lname, $phone, $email, $address_, $city, $province, $postal, $dob, $id);
            
            // $stmt->execute();
            if ($stmt->execute() === TRUE) {
                echo "Record updated successfully";
                echo '<a  class="btn btn-outline-primary" href="menu.php">Back to menu</a>';
              } else {
                echo "Error updating record: " . $conn->error;
              }
              
            
            $conn->close();


        } else {
            echo "<h4>Check Fields";
        }
    }











require 'footer.php'; 



?>




