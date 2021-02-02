<?php 
    session_start();

    if (!isset($_SESSION["authenticated"]) && !$_SESSION["authenticated"] == true) {
        header('Location: index.php');
        exit;
    }

    require 'header.php';


    
    if (isset($_POST["confirm"]) && $_POST["confirm"] != 0){
        require 'credentials.php';

        $conn = new mysqli($servername, $username, $password, $db_name);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
            
        $stmt = $conn->prepare("DELETE FROM $table_name WHERE id = ?") ;

        $stmt->bind_param("i", $id);
        $id = $_POST["confirm"];
        $stmt->execute();
        $conn->close();

        echo "<h4>The record deleted</h4>";
        echo '<a  class="btn btn-outline-primary" href="menu.php">Return to menu</a>';
    }
    require 'footer.php';
?>