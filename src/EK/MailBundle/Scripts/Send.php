<?php
set_time_limit(1440000000);
date_default_timezone_set('Etc/UTC');
require 'Funcs.php';

if (isset($argv[1])) {


    $db = Database::getInstance();

    $chemin = "../../../../web/logs/".$argv[1]."/";
    $file = fopen($chemin."log.txt","a");

    $mail = getMail($argv[1], $chemin, $db);
    $infoCampagne = infoCampagne($argv[1], $db);

    $emails  = file($chemin."emails.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $ipsTemp  = file($chemin."ips.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $ips = getTabIps($ipsTemp);


    $i=0;
    $j=0;
    $limit = $infoCampagne[0];
    $waiting = $infoCampagne[1];
    $total = count($emails);

    while(!empty($emails)) {

        if(verifyPause($chemin, $j, $argv[1], $db)) {
            fwrite($file,"lancement arreter .... "."\n");
            file_put_contents($chemin."emails.txt", implode("\r\n", $emails));
            exit;
        }

        $mail->Host = $ips[$i][0];
        $mail->Username = $ips[$i][2];
        $mail->Password = $ips[$i][3];

        if($i == count($ips)) { $i = 0;}

        $tmpLimit = 0;
        for($k=0; $k<$limit; $k++) {
            $tmpLimit++;
            $mail->AddAddress(trim($emails[$j]));
            fwrite($file,"lanser ".$emails[$j]." avec ".$ips[$i][0]." a ".date("H:i:s")."\n");
            unset($emails[$j++]);
            if($j==$total) { break;}

        }
        /*if($mail->send()) {fwrite($file,"lancement ok .... "."\n"); }
        else {fwrite($file,"KO : ".$mail->ErrorInfo."\n");}*/
        $mail->ClearAddresses();
        majNumSent($chemin, $tmpLimit);
        usleep($waiting);
        $i++;




    }



    fwrite($file,"FIN de lancement ...."."\n");
    file_put_contents($chemin."emails.txt", implode("\r\n", $emails));
    file_put_contents($chemin."pause.txt", "1");
    verifyPause($chemin, $j, $argv[1], $db);
    fclose($file);


}





?>