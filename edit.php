<?php 
    require 'components/check_session.php';

    require 'components/header.php';


//================================================================ create form and populate it
    require 'components/add_edit_form.php'; 
    

    if (isset($_POST["edit"]) && $_POST["edit"] != 0){
        echo "<h4 style='color:orange';>Edit the record:</h4>";
        require 'classes/ClientManager.php';
        $ClientManager = new ClientManager();
        $id = $_POST["edit"];

        $client_array = $ClientManager->get_client_by_ID ($id);

        add_edit_form( $client_array );

        $ClientManager->show_msg ();
    }


    if (isset($_POST["submit"]) && $_POST["submit"] != 0){
        
        require 'classes/ClientManager.php';
        $ClientManager = new ClientManager();
        $ClientManager->get_client_from_POST();
        $id = $_POST["submit"];
 
        $result = $ClientManager->update_by_ID($id);
        if ($result) {
            $ClientManager->show_msg ();
            echo "<a  class='btn btn-outline-primary' href='main.php'>Return to main</a>";
        } else {
            echo "<h4 style='color:orange';>Edit the record:</h4>";
            add_edit_form($ClientManager->client->get_client_array());
        }

    } 


    require 'components/footer.php'; 

?>


