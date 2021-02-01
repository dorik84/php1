<?php 
    $ini_array = parse_ini_file("config.ini");


    $db_name = $ini_array["db_name"];
    $table_name = $ini_array["table_name"];
    $servername =$ini_array["servername"];
    $username=$ini_array["username"];
    $password=$ini_array["password"];
    $table_name_auth=$ini_array["table_name_auth"];
    
?>