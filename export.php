<?php require 'header.php';?>
<nav class="navbar navbar-expand-lg navbar-light " style="background-color: #e3f2fd;">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">CLIENTS</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">

        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link " href="menu.php" >All contacts</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="add_new_contact.php" >Add new contact</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="birthday.php" >Birthday</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="send_email.php" >Send email</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="import.php" >Import</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="export.php" >Export</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="logout">Logout</a>
            </li>
        </ul>
        </div>
    </div>
</nav>




<?php 
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