<?php
set_time_limit(1440000000);
date_default_timezone_set('Etc/UTC');
require 'Funcs.php';

if (isset($argv[1])) {

    $db = Database::getInstance();


    $chemin = "../../../../web/globalTest/".$argv[1]."/";
    $file = fopen($chemin."log.txt","a");
    //fwrite($file,"Start ....  "."\n");

    $mail = getMailTestGlobal($argv[1], $db);
    $waiting = infoGlobalTest($argv[1], $db);

    //fwrite($file,"waiting ".$waiting." avec ".$mail->Subject."\n");

    $emails  = file($chemin."emails.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $ipsTemp  = file($chemin."ips.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $ips = getTabIps($ipsTemp);

    fwrite($file,"---GLOBAL TEST STARTED AT ".date("d/m/Y , H:i:s")."\n");

    foreach($emails as $email) {

        $mail->AddAddress(trim($email));

        foreach($ips as $ip) {
            $mail->Host = $ip[0];
            $mail->Username = $ip[2];
            $mail->Password = $ip[3];


            if($mail->send()) {fwrite($file,"Ok GlobalTest: ".$email." with ".$ip[0]."\n"); }
            else {fwrite($file,"Error GlobalTest: ".$email." with error : ".$mail->ErrorInfo."\n");}

        }
        $mail->ClearAddresses();
        usleep($waiting);
    }


    fclose($file);













}





























?>