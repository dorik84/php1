<?php 
    session_start();
    if (!isset($_SESSION["authenticated"]) && $_SESSION["authenticated"] != true) {
        header('Location: index.php');
        exit;
    }
    require 'header.php';

    require 'navbar.php';
    navbar("Send email");
?>



<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
    <div class="form-group">
        <label >Subject</label>
        <input type="text" class="form-control"  name="subject" maxlength="30" required>
    </div>

    <div class="form-group">
        <label for="exampleFormControlTextarea1">Message</label>
        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" maxlength="255" name="msg" required></textarea>
    </div>

    <button type="submit" name="submit" class="btn btn-primary my-3">Send emails</button>
</form>



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
        echo "here";
        $_subject = test_input($_POST["subject"]);
        $_msg = test_input($_POST["msg"]);
    

        if (count($GLOBALS["error"]) == 0) {

            require 'credentials.php';

            $conn = new mysqli($servername, $username, $password, $db_name);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
                
            $sql = "SELECT email from $table_name" ;
            $result = $conn->query($sql);

            if (@$result->num_rows > 0) {

                while($row = $result->fetch_assoc()) {

                    foreach ($row as &$value) {

                        $to_email = $value;
                        $subject = $GLOBALS["_subject"];
                        $message = $GLOBALS["_msg"];
                        $headers = 'From: spivpracya@mail.ru';
                        mail($to_email,$subject,$message,$headers);
                    }
                }

            } else {
                echo "<h4> The database is empty. Or an error occured</h4>";
            }


            $conn->close();

        } else echo "<h4>Please, fill out all fields</h4>";
    }
    require 'footer.php';

?>