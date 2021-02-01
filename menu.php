<?php 
    session_start();

    if (!isset($_SESSION["authenticated"]) && !$_SESSION["authenticated"] == true) {
        header('Location: index.php');
        exit;
    }

    require 'header.php';
?>



        <nav class="navbar navbar-expand-lg navbar-light " style="background-color: #e3f2fd;">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">CLIENTS</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">

                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="#" >All contacts</a>
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
                        <a class="nav-link " href="export.php" >Export</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="logout">Logout</a>
                    </li>
                </ul>
                </div>
            </div>
        </nav>

    

    <?php 
        require 'credentials.php';

        $conn = new mysqli($servername, $username, $password, $db_name);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
            
        $sql = "SELECT fname, lname, phone, email, address_, city, province, postal, dob from $table_name" ;
        $result = $conn->query($sql);

        if (@$result->num_rows > 0) {

            require 'table_start.php';

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
            echo "<h4>No data in database</h4>";
        }


        $conn->close();
    
    ?>


        
<?php require 'footer.php'; ?>