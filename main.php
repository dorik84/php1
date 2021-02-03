<?php 
    require 'components/check_session.php';

    require 'components/header.php';
    require 'components/navbar.php';
    navbar();

    echo '<div class="container-fluid d-flex flex-column justify-content-center align-items-center">';
    echo "<h4 class='text-primary align-middle py-3'>All contacts:</h4>";

    require 'classes/ClientManager.php';
    $ClientManager = new ClientManager();
    $ClientManager->show_db();

    echo '</div>'; 
    require 'components/footer.php'; 
?>