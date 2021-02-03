<?php 
    require 'components/check_session.php';
    
    require 'components/header.php';
    require 'components/navbar.php';
    navbar("Export");

    
    require 'classes/ClientManager.php';
    $ClientManager = new ClientManager();
    $ClientManager->export_clients_db ();
    $ClientManager->show_msg ();

    
    require 'components/footer.php';
    
?>