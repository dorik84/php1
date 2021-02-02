<?php
  session_start();
  


  require 'header.php';
?>


<h4>Login:</h4>
<form class="col col-sm-10 col-md-8 col-lg-6" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email address</label>
        <input type="email" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp">

    </div>
    
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Password</label>
        <input type="password" class="form-control" id="exampleInputPassword1"  name="password">
    </div>

    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
</form>


<?php require 'footer.php'; 



if (isset($_POST['submit'])) {

  if ( isset($_POST['email']) && isset($_POST['password']) && !empty($_POST['email']) && !empty($_POST['password']) ) {

    
    function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    };
    
    $email = test_input($_POST['email']);
    $pswd = test_input($_POST['password']);
      
      
      



  /*
    //hash password
    $hash = password_hash($password, PASSWORD_DEFAULT);
    
    //save new creds
    $conn = new mysqli($servername, $username, $password, $db_name);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $stmt = $conn->prepare( "INSERT INTO $table_name_auth (email, hash) VALUES (?,?)" );
    $stmt->bind_param("ss", $email, $hash );


    $stmt->execute();

  */

      require "credentials.php";
    
      //retrieve hash from db
      $conn = new mysqli($servername, $username, $password, $db_name);
      if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
      }
      $stmt = $conn->prepare( "SELECT hash from $table_name_auth WHERE email = (?)" );
      $stmt->bind_param("s", $email );


      $stmt->execute();
      $stmt->bind_result($retrieved_hash);
      $stmt->fetch();
      
      if (password_verify($pswd, $retrieved_hash)) {
        $_SESSION["authenticated"] = true;
        header('Location: main.php');
      } else {
        echo "<p class='text-danger'>Invalid password</p>";
      }
      $conn->close();
  } else echo"<p class='text-danger'>All fields are required</p>";
}

?>
