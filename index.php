<?php
session_start();
if (isset($_SESSION["authenticated"]) && $_SESSION["authenticated"] === true) {
    header('Location: main.php');
    exit;
}
  require 'components/header.php';
?>

<div class="container-fluid d-flex flex-column justify-content-center align-items-center">
  <h4>Login:</h4>
  <form class="col col-sm-8 col-md-6 col-lg-4" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
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


<?php  

if (isset($_POST['submit'])) {

  require 'classes/ClientManager.php';
  $ClientManager = new ClientManager();
  $ClientManager->login_info->set_email($_POST['email']);
  $ClientManager->login_info->set_password($_POST['password']);
  // $ClientManager->create_tbl_auth();
  // $ClientManager->create_account ();
  $ClientManager->authenticate();
}

require 'components/footer.php';

?>
</div>
