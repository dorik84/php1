<?php 
    require 'components/check_session.php';
    
    require 'components/header.php';
    require 'components/navbar.php';
    navbar("Export");

    
    require 'classes/ClientManager.php';
    $ClientManager = new ClientManager();
    $ClientManager->export_clients_db ();
    echo '<div class="container-fluid d-flex flex-column justify-content-center align-items-center">';
    $ClientManager->show_msg ();
    echo '</div>';
    
    require 'components/footer.php';
    
?>