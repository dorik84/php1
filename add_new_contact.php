<?php 
    session_start();
    if (!isset($_SESSION["authenticated"]) && $_SESSION["authenticated"] != true) {
        header('Location: index.php');
        exit;
    }
    require 'header.php';
?>

<!-- //========================================================================================== HTML FORM -->
<nav class="navbar navbar-expand-lg navbar-light mb-5" style="background-color: #e3f2fd;">
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
                <a class="nav-link active" href="add_new_contact.php" >Add new contact</a>
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



<form class="row g-3" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">

    <div class="row" >
        <div class="col py-1">
            <label  class="form-label">First Name</label>
            <input type="text" class="form-control" placeholder="First name" name="fname" aria-label="First name" maxlength="30" required>
        </div>
        <div class="col py-1">
            <label  class="form-label">Last Name</label>
            <input type="text" class="form-control" placeholder="Last name" name="lname" aria-label="Last name" maxlength="30" required>
        </div>
    </div>


    <div class="row">
        <div class="col py-1">
            <label for="inputEmail4" class="form-label">Email</label>
            <input type="email" class="form-control" id="inputEmail4" name="email" placeholder="sample@sample.ca" maxlength="30" required>
        </div>
        <div class="col py-1">
            <label for="phone" class="form-label">Phone</label>
            <input type="tel" class="form-control" id="inputPassword4" name="phone" placeholder="1-234-567-8899" maxlength="12" >
        </div>
    </div>

    <div class="row">
        <div class="col py-1">
            <label for="inputAddress" class="form-label">Address</label>
            <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St" name="address" maxlength="50">
        </div>
    </div>

    <div class="row">
        <div class="col py-1">
            <label for="inputCity" class="form-label">City</label>
            <input type="text" class="form-control" id="city" name="city" placeholder="New York" maxlength="20">
        </div>
        <div class="col py-1">
            <label for="inputState" class="form-label">State</label>
            <select id="inputState" class="form-select" maxlength="2" name="state">
                <option selected>Choose...</option>
                <option>AB</option>
                <option>BC</option>
                <option>MB</option>
                <option>NB</option>
                <option>NL</option>
                <option>NT</option>
                <option>NS</option>
                <option>NU</option>
                <option>ON</option>
                <option>PE</option>
                <option>QC</option>
                <option>SK</option>
                <option>YT</option>
            </select>
        </div>
        <div class="col py-1">
            <label for="inputZip" class="form-label">Postal Code</label>
            <input type="text" class="form-control" id="zip" name="postal" placeholder="B2N 0A9" maxlength="7">
        </div>
        <div class="col py-1">
            <label for="inputZip" class="form-label">Date of Birth</label>
            <input type="date" class="form-control" id="dob" name="dob" placeholder="yyyy-mm-dd" maxlength="10" required>
        </div>
    </div>


        
    <div class="col py-1">
        <button type="submit" name="submit" class="btn btn-primary">Add Client</button>
    </div>
</form>

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