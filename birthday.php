<?php 
    require 'components/check_session.php';
    

    require 'components/header.php';
    require 'components/navbar.php';
    navbar("Birthday");

    echo '<div class="container-fluid d-flex flex-column justify-content-center align-items-center">';
    echo "<h4 class='text-primary align-middle py-3'>Birthday people this month</h4>";
  

    require 'classes/ClientManager.php';
    $ClientManager = new ClientManager();
    $ClientManager->show_birthday_people ();

    echo '</div>';
    require 'components/footer.php'; 
?>