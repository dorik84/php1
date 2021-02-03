<?php
  session_start();
  require 'components/header.php';
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


<?php require 'components/footer.php'; 

if (isset($_POST['submit'])) {

    require 'classes/ClientManager.php';
    $ClientManager = new ClientManager();
    $ClientManager->login_info->set_email($_POST['email']);
    $ClientManager->login_info->set_password($_POST['password']);
    // $ClientManager->create_tbl_auth();
    // $ClientManager->create_account ();
    $ClientManager->authenticate();



   
}

?>
