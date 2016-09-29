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
    $tracking = $infoCampagne[2];
    $emailTest = $infoCampagne[3];
    $feedback = $infoCampagne[4];
    $html = $mail->Body;
    $total = count($emails);

    fwrite($file,"---SEND STARTED AT ".date("d/m/Y , H:i:s")."\n");

    while(!empty($emails)) {


        if(verifyPause($chemin, $j, $argv[1], $db)) {
            //fwrite($file,"lancement arreter .... "."\n");
            fwrite($file,"---SEND STOPPED AT ".date("d/m/Y , H:i:s")."\n");
            file_put_contents($chemin."emails.txt", implode("\r\n", $emails));
            fclose($file);
            exit;
        }

        if($i == count($ips)) { $i = 0;}
        $mail->Host = $ips[$i][0];
        $mail->Username = $ips[$i][2];
        $mail->Password = $ips[$i][3];



        $tmpLimit = 0;
        for($k=0; $k<$limit; $k++) {

            if($j%$feedback==0) {
                $mail->AddAddress(trim($emailTest));
                $mail = getTrackHtml($mail, 0, $html);
                //fwrite($file,"lanser ".$emailTest." avec ".$ips[$i][0]." a ".date("H:i:s")."\n");
                //fwrite($file,"lanser ".$mail->Body."\n\n\n");
                //if($mail->send()) {fwrite($file,"lancement ok .... "."\n"); }
                if($mail->send()) {fwrite($file,"FeedBack ok : ".$emailTest." with ".$ips[$i][0]."\n"); }
                else {fwrite($file,"Error FeedBack : ".$emailTest." with error : ".$mail->ErrorInfo."\n");}
                $mail->ClearAddresses();
            }

            $tmpLimit++;
            $email = explode(',', $emails[$j]); // new line

            if($tracking) {
                $mail = getTrackHtml($mail, $email[1], $html);
            }

            $mail->AddAddress(trim($email[0]));
            //fwrite($file,"lanser ".$email[0]." avec ".$ips[$i][0]." a ".date("H:i:s")."\n");
            //fwrite($file,"lanser ".$mail->Body."\n\n\n");
            unset($emails[$j++]);
            //if($mail->send()) {fwrite($file,"lancement ok .... "."\n"); }
            if($mail->send()) {fwrite($file,"Ok : ".$email[0]." with ".$ips[$i][0]."\n"); }
            else {fwrite($file,"Error : ".$email[0]." with error : ".$mail->ErrorInfo."\n");}
            $mail->ClearAddresses();
            if($j==$total) { break;}

        }

        majNumSent($chemin, $tmpLimit);
        usleep($waiting);
        $i++;




    }



    //fwrite($file,"FIN de lancement ...."."\n");
    fwrite($file,"---CAMPAGNE COMPLETED AT ".date("d/m/Y , H:i:s")."\n");
    file_put_contents($chemin."emails.txt", implode("\r\n", $emails));
    file_put_contents($chemin."pause.txt", "1");
    verifyPause($chemin, $j, $argv[1], $db);
    fclose($file);


}





?>