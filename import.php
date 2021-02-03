<?php 
    require 'components/check_session.php';

    require 'components/header.php';
    require 'components/navbar.php';
    navbar("Import");


    $self_server_url = $_SERVER['PHP_SELF'];
    echo <<<FORM
        <form action="$self_server_url" method="post" enctype="multipart/form-data" class=" col-12 col-sm-10 col-md-8 col-lg-6">
            <label class="form-label"><h4>Select file to upload:</h4></label>
            <div class="input-group">
                <input type="file" class="form-control" name="csv_file">
                <button class="btn btn-outline-secondary" type="submit" >Import</button>
            </div>
        </form>
    FORM;
    


    //================================================================ error checking uploaded file
    if (isset($_FILES['csv_file'])) {


        require 'classes/ClientManager.php';
        $ClientManager = new ClientManager();
        $ClientManager->create_tbl();
        $ClientManager->import_db_from_file ($_FILES['csv_file']);
        $ClientManager->file->safe_file();
        $ClientManager->show_msg ();
    } 
    
    require 'components/footer.php';

?>




