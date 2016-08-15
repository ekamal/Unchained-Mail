<?php
set_time_limit(1440000000);
date_default_timezone_set('Etc/UTC');
require 'PHPMailer/PHPMailerAutoload.php';
$mail = new PHPMailer;

if (isset($argv[1])) {
   
   $conn = new mysqli('localhost', 'root', '', 'ekmail');
   $sql = "SELECT * FROM campagne WHERE id=".$argv[1]."";
   $result = $conn->query($sql);
   $row = $result->fetch_assoc();
   $conn->close();

    $chemin = "../../../../web/logs/".$argv[1]."/";
    $file = fopen($chemin."log.txt","a");



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

    $numSentFile = fopen($chemin."numSent.txt", 'r');
    $numSent = fgets($numSentFile);
    fclose($numSentFile);
    $numNoSentFile = fopen($chemin."numNoSent.txt", 'r');
    $numNoSent = fgets($numNoSentFile);
    fclose($numNoSentFile);

    $i=0;
    $j=0;
    foreach ($emails  as  $email) {

        if($i == count($ips)) { $i = 0;}

        fwrite($file,"lanser ".$email." avec ".$ips[$i][0]." a ".date("H:i:s")."\n");
        unset($emails[$j]);
        $i=$i+1;
        $j=$j+1;
        sleep(5);


        $numSent = $numSent+1;
        file_put_contents($chemin."numSent.txt", $numSent);
        $numNoSent = $numNoSent-1;
        file_put_contents($chemin."numNoSent.txt", $numNoSent);



        $pauseFile = fopen($chemin."pause.txt", 'r');
        $pause = fgets($pauseFile);
        if($pause=="1")
        {
            file_put_contents($chemin."emails.txt", implode("\r\n", $emails));
            $conn = new mysqli('localhost', 'root', '', 'ekmail');
            $sql = "UPDATE campagne SET numSent=".$numSent." WHERE id=".$argv[1]."";
            $result = $conn->query($sql);
            $sql = "UPDATE campagne SET numNoSent=".$numNoSent." WHERE id=".$argv[1]."";
            $result = $conn->query($sql);
            $conn->close();
            fwrite($file,"lancement arreter .... "."\n");
            exit;
        }
        fclose($pauseFile);

    }

    file_put_contents($chemin."emails.txt", implode("\r\n", $emails));
    file_put_contents($chemin."pause.txt", "1");

    $conn = new mysqli('localhost', 'root', '', 'ekmail');
    $sql = "UPDATE campagne SET pause=1 WHERE id=".$argv[1]."";
    $result = $conn->query($sql);
    $sql = "UPDATE campagne SET numSent=".$numSent." WHERE id=".$argv[1]."";
    $result = $conn->query($sql);
    $sql = "UPDATE campagne SET numNoSent=".$numNoSent." WHERE id=".$argv[1]."";
    $result = $conn->query($sql);
    $conn->close();

    fwrite($file,"FIN de lancement ....");



    fclose($file);
}





?>