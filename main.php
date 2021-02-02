<?php 
    session_start();

    if (!isset($_SESSION["authenticated"]) && !$_SESSION["authenticated"] == true) {
        header('Location: index.php');
        exit;
    }

    require 'header.php';

    require 'navbar.php';
    navbar();

    require 'credentials.php';

    $conn = new mysqli($servername, $username, $password, $db_name);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
        
    $sql = "SELECT id, fname, lname, phone, email, address_, city, province, postal, dob from $table_name" ;
    $result = $conn->query($sql);

    if (@$result->num_rows > 0) {

        require 'table_start.php';

        // $row_number=1;
        while($row = $result->fetch_assoc()) {
            $id= $row['id'];
            echo "<tr>";

            echo <<<BUTTONS
            <td scope='col'>
                <div class="btn-group btn-group-sm" role="group" >
                <form action="delete.php" method="post">
                    <button type="submit" class="btn btn-outline-danger" name="delete" value="$id">Delete</button>
                </form>
                <form action="edit.php" method="post">
                    <button type="submit" class="btn btn-outline-success" name="edit" value="$id">Edit</button>
                </form>
                </div>
            </td>
            BUTTONS;

            // echo" <td scope='col'>$row_number</td>";
            foreach ($row as $key => &$value) {

                if ($key === "id") continue;
                echo" <td scope='col'>$value</td>";
            }
            echo "</tr>";
            // $row_number++;
        }
        echo "</tbody></table>";
    } else {
        echo "<h4>No data in database</h4>";
    }


    $conn->close();
        
    require 'footer.php'; 
?>