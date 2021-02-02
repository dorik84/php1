<?php 
    
    require 'header.php';
    require 'navbar.php';
    navbar("Export");


    session_start();
    if (!isset($_SESSION["authenticated"]) && $_SESSION["authenticated"] != true) {
        header('Location: index.php');
        exit;
    }

    require 'credentials.php';

    $conn = new mysqli($servername, $username, $password, $db_name);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM tbl_clients";
    $result = $conn->query($sql);
   
    if ($result){
        if ($result->num_rows > 0) {

            if (!is_dir ( 'public' )) mkdir('./public/', 0777, true);

            $open= fopen("./public/export.csv", "w");

            while($row = $result->fetch_assoc()) {
                $data = array(  $row["fname"], $row["lname"], $row["phone"], $row["email"], $row["address_"], $row["city"], $row["province"], $row["postal"],$row["dob"] );
                fputcsv($open, $data);
            }

            fclose($open);

            echo '<a href="./public/export.csv"><h4>Download</h4></a>';
        } else {
            echo "0 results";
        }
    } else echo "<h4>No database to export</h4>";
    $conn->close();

    
    require 'footer.php';
    
?>