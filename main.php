<?php 
    require 'components/check_session.php';

    require 'components/header.php';
    require 'components/navbar.php';
    navbar();


    require 'classes/ClientManager.php';
    $ClientManager = new ClientManager();
    $ClientManager->show_db();

    
    require 'components/footer.php'; 
?>