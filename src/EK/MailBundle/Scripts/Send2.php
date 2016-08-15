<?php
set_time_limit(1440000000);
date_default_timezone_set('Etc/UTC');
//require 'PHPMailer/PHPMailerAutoload.php';
require 'Funcs.php';
//$mail = new PHPMailer;

if (isset($argv[1])) {

    /*$conn = new mysqli('localhost', 'root', '', 'ekmail');
    $sql = "SELECT * FROM campagne WHERE id=".$argv[1]."";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $conn->close();*/



    $chemin = "../../../../web/logs/".$argv[1]."/";
    $file = fopen($chemin."log.txt","a");

    $mail = getMail($argv[1], $chemin);
    /*fwrite($file,$mail->Body."\n");
    fwrite($file,$mail->Sender."\n");
    fwrite($file,$mail->MessageID."\n");*/



    $emails  = file($chemin."emails.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $ipsTemp  = file($chemin."ips.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $ips=array();

    $i=0;
    foreach($ipsTemp as $ip)
    {
        $line = explode(',', $ip);
        $ips[$i][0]=$line[0];
        $ips[$i][1]=$line[1];
        $ips[$i][2]=$line[2];
        $ips[$i][3]=$line[3];
        $i=$i+1;
    }

    $i=0;
    $j=0;
    $limit = 4;
    $total = count($emails);

    while(!empty($emails)) {

        if(verifyPause($chemin, $j, $argv[1])) {
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
        if($mail->send()) {fwrite($file,"lancement ok .... "."\n"); }
        else {fwrite($file,"KO : ".$mail->ErrorInfo."\n");}
        $mail->ClearAddresses();
        majNumSent($chemin, $tmpLimit);
        sleep(3);
        //usleep($waiting);
        $i++;




    }



    fwrite($file,"FIN de lancement ....");
    file_put_contents($chemin."emails.txt", implode("\r\n", $emails));
    file_put_contents($chemin."pause.txt", "1");
    verifyPause($chemin, $j, $argv[1]);
    fclose($file);


}





?>