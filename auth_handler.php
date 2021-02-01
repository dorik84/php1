<?php

  require "credentials.php";
  session_start();


    //redirect to index if credentials aren't set
  if ( !isset($_POST['email']) || !isset($_POST['password']) || $_POST['email']=="" || $_POST['password']=="" || $_POST['email']==" " || $_POST['password']==" ") {
      header("Location: index.php");
      exit;
};


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = test_input($_POST['email']);
    $pswd = test_input($_POST['password']);

  };
  

  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  };


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
    header('Location: menu.php');
  } else {
    echo 'Invalid password.';
  }
  $conn->close();
?>

