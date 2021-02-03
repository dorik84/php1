<?php 
    require 'components/check_session.php';

    require 'components/header.php';



    if (isset($_POST["delete"]) && $_POST["delete"] != 0){
        
        require 'classes/ClientManager.php';
        $ClientManager = new ClientManager();
        $id = $_POST["delete"];
        echo "<h4 style='color:orange';>Confirm delition</h4>";
        $ClientManager->show_client_byID ($id);

        $ClientManager->show_msg ();
        
        
        echo <<<BUTTON
        <form action="confirm_delete.php" method="post">
            <button type="submit" class="btn btn-outline-danger" name="confirm" value="$id">Delete</button>
            <a  class="btn btn-outline-primary" href="main.php">Cancel</a>
        </form>
        BUTTON;
    }

    require 'components/footer.php'; ?>




