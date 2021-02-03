<?php 
    require 'components/check_session.php';
    

    require 'components/header.php';
    require 'components/navbar.php';
    navbar("Birthday");


    echo"<h4>Birthday people this month</h4>";
    

    require 'classes/ClientManager.php';
    $ClientManager = new ClientManager();
    $ClientManager->show_birthday_people ();

    require 'components/footer.php'; 
?>