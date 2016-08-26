<?php
set_time_limit(3600);
date_default_timezone_set('Etc/UTC');
require 'Funcs.php';

if (isset($argv[1])) {

    $db = Database::getInstance();
    $chemin = "../../../../web/logs/".$argv[1]."/";
    $file = fopen($chemin."log.txt","a");


    $mail = getMail($argv[1], $chemin, $db);
    $emailTest = getEmailTest($argv[1], $db);

    $ipsTemp  = file($chemin."ips.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $ip = explode(',', $ipsTemp[0]);

    $mail->Host = $ip[0];
    $mail->Username = $ip[2];
    $mail->Password = $ip[3];

    $mail->AddAddress(trim($emailTest));

    fwrite($file,"Test Campagne : ".$emailTest." avec ".$ip[0]." a ".date("H:i:s")." Subject : ".$mail->Subject."\n");

    /*if($mail->send()) {fwrite($file,"test campagne ok .... "."\n"); }
        else {fwrite($file,"KO test campagne : ".$mail->ErrorInfo."\n");}*/

    fclose($file);



}