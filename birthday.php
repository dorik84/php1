<?php 
    session_start();

    if (!isset($_SESSION["authenticated"]) && !$_SESSION["authenticated"] == true) {
        header('Location: index.php');
        exit;
    }

    require 'header.php';

    require 'navbar.php';
    navbar("Birthday");
?>



    <h4>Birthday people this month</h4>
    

<?php 
    require 'credentials.php';

    $conn = new mysqli($servername, $username, $password, $db_name);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $current_month = date("m");

    $sql = "SELECT fname, lname, phone, email, address_, city, province, postal, dob from $table_name WHERE MONTH(dob) = $current_month ORDER BY dob ASC; ";
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