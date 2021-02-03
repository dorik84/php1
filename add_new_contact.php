<?php 
    require 'components/check_session.php';

    require 'components/header.php';
    require 'components/navbar.php';
    navbar("Add new contact");

    require 'components/add_edit_form.php'; 
    
    echo '<div class="container-fluid d-flex flex-column justify-content-center align-items-center">';
    echo "<h4 class='text-primary align-middle py-3'>Add new client:</h4>";
    
    if (isset($_POST['submit'])) {

        require 'classes/ClientManager.php';
        $ClientManager = new ClientManager();
        $ClientManager->get_client_from_POST();
        $ClientManager->create_tbl();
        $ClientManager->add_one_client();
        add_edit_form($ClientManager->client->get_client_array());
        $ClientManager->show_msg ();

    } else add_edit_form();

    echo '</div>';

?>