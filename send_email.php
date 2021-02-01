<?php     
    $to_email = 'dorya2005@mail.ru';
    $subject = 'Testing PHP Mail';
    $message = 'This mail is sent using the PHP mail function';
    $headers = 'From: spivpracya@mail.ru';
    mail($to_email,$subject,$message,$headers);
?>