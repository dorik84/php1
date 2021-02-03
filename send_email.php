<?php 
    require 'components/check_session.php';
    require 'components/header.php';

    require 'components/navbar.php';
    navbar("Send email");
?>


<div class="container-fluid d-flex flex-column justify-content-center align-items-center">
<h4 class='text-primary align-middle py-3'>Newsletter form:</h4>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" class="col col-sm-10 col-md-8 col-lg-6">
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
</div>


<?php     


    if (isset($_POST["submit"])){

        require 'classes/ClientManager.php';
        $ClientManager = new ClientManager();
        $ClientManager->newsLetter->set_subject($_POST["subject"]);
        $ClientManager->newsLetter->set_msg($_POST["msg"]);
        $ClientManager->send_news_letter();
    }
        
  
                
    require 'components/footer.php';

?>