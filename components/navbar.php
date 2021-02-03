
<?php 
function navbar ($where = "All contacts"){
    echo <<<begginning
        <nav class="navbar navbar-expand-lg navbar-light mb-3" style="background-color: #e3f2fd;">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">CLIENTS</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">

                <ul class="navbar-nav">
    begginning;

    $array= array("main.php"=>"All contacts", "add_new_contact.php" => "Add new contact", "birthday.php" => "Birthday", "send_email.php" => "Send email", "import.php" => "Import", "export.php" =>"Export", "logout.php"=> "Logout");
    foreach ($array as $url => $name) {
        if ($name === $where) {
            echo "<li class='nav-item'>
            <a class='nav-link active' href='$url' >$name</a>
            </li>";
        } else {
            echo "<li class='nav-item'>
            <a class='nav-link' href='$url' >$name</a>
            </li>";
        }
    }

    echo <<<ending
                </ul>
                </div>
            </div>
        </nav>
    ending;
}
?>