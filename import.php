<?php 
    session_start();
    if (!isset($_SESSION["authenticated"]) && $_SESSION["authenticated"] != true) {
        header('Location: index.php');
        exit;
    }
    require 'header.php';

    require 'navbar.php';
    navbar("Import");
?>





<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" class=" col-12 col-sm-10 col-md-8 col-lg-6">
    <label class="form-label"><h4>Select file to upload:</h4></label>
    <div class="input-group">
        <input type="file" class="form-control" name="csv_file">
        <button class="btn btn-outline-secondary" type="submit" >Import</button>
    </div>
</form>

<?php 
    

    //================================================================ error checking uploaded file
    if (isset($_FILES['csv_file'])) {

        $errors= array();
        $file_name = $_FILES['csv_file']['name'];
        $file_size = $_FILES['csv_file']['size'];
        $file_tmp = $_FILES['csv_file']['tmp_name'];
        $file_type = $_FILES['csv_file']['type'];
        $file_ext = strtolower(pathinfo($file_name,PATHINFO_EXTENSION));
        

        
        if($_FILES['csv_file']['error'] != 0 ){
            $errors[]="no files were chosen.";
        }

        else if($file_ext !== "csv"){
            $errors[]="The extension is not allowed, please choose a CSV file.";
        }
        
        else if($file_size > 2097152){
            $errors[]='File size must be excately 2 MB';
        }
        

        


        //================================================================ reading file and output
        function readAndOutput ($new_file_name) {
            if (($open = fopen($new_file_name, "r")) !== FALSE) {
            echo "<h4>Following data is imported into the existing database</h4>";
            require 'table_start.php';
                $row_number=1;
                while (($data = fgetcsv($open, 1000, ",")) !== FALSE) {
                    if (count($data)>1){


                        echo "<tr>";
                        echo" <td scope='col'>$row_number</td>";
                        foreach ($data as &$value) {
                            echo" <td scope='col'>$value</td>";
                        }
                        echo "</tr>";
                        $row_number++;
                    }
                }

                echo "</tbody></table>";
                fclose($open);
            }
        }




        //================================================================ saving file
        if(empty($errors) == true){
            
            $new_file_name =  "./uploads/". sha1_file($file_tmp) . ".csv";

            if(!is_dir ("uploads")){
                mkdir("./uploads", 0777);
            }
            copy($file_tmp, $new_file_name);


            readAndOutput($new_file_name);
 

        }else{
            echo '<h4>Next error(s) occured:</h4><ul>';
            foreach($errors as $value) {
                echo "<li>$value</li>";
            }
            echo '</ul>';
            exit;
        }   



        //================================================================ import into MySQL Database

        require 'credentials.php';
        //initialize connection
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

        


        //insert data

        $stmt = $conn->prepare("INSERT INTO tbl_clients (fname, lname, phone, email, address_, city, province, postal, dob) VALUES (?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param("sssssssss", $fname, $lname, $phone, $email, $address_, $city, $province, $postal, $dob);
        
        if (($open = fopen($new_file_name, "r")) !== FALSE) {
            while (($data = fgetcsv($open, 1000, ",")) !== FALSE) {
                if (count($data)>1){
                    $fname = $data["0"];
                    $lname = $data["1"];
                    $phone = $data["2"];
                    $email = $data["3"];
                    $address_ = $data["4"];
                    $city = $data["5"];
                    $province = $data['6'];
                    $postal = $data["7"];
                    $dob = $data['8'];

                    $stmt->execute();
                }

            }
            fclose($open);
        }


        $conn->close();

    };

    require 'footer.php';

?>




