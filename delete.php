<?php 
    session_start();

    if (!isset($_SESSION["authenticated"]) && !$_SESSION["authenticated"] == true) {
        header('Location: index.php');
        exit;
    }

    require 'header.php';
    require 'navbar.php';
    navbar("All contacts");



if (isset($_POST["delete"]) && $_POST["delete"] != 0){
    require 'credentials.php';

    $conn = new mysqli($servername, $username, $password, $db_name);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
        
    $stmt = $conn->prepare("SELECT fname, lname, phone, email, address_, city, province, postal, dob from $table_name WHERE id = ?") ;
    $stmt->bind_param("i", $id);
    $id = $_POST["delete"];
    $stmt->execute();
    $result = $stmt->get_result();

    // $contacts = $result->fetch_all(MYSQLI_ASSOC);

    echo "<h4>Do you really want to delete this contact?</h4>";
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


    $conn->close();

    echo <<<BUTTON
    <form action="confirm_delete.php" method="post">
        <button type="submit" class="btn btn-outline-danger" name="confirm" value="$id">Delete</button>
        <a  class="btn btn-outline-primary" href="menu.php">Cancel</a>
    </form>
    BUTTON;
}

require 'footer.php'; ?>




