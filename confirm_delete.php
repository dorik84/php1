<?php 
    require 'components/check_session.php';

    require 'components/header.php';

    if (isset($_POST["confirm"]) && $_POST["confirm"] != 0){

        require 'classes/ClientManager.php';
        $ClientManager = new ClientManager();
        $id = $_POST["confirm"];

        $ClientManager->delete_by_ID ($id);
    
        $ClientManager->show_msg ();
        echo '<a  class="btn btn-outline-primary" href="main.php">Return to main page</a>';

    }

    require 'components/footer.php';
?>