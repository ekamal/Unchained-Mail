<?php

//date_default_timezone_set('Etc/UTC');
require 'PHPMailer/PHPMailerAutoload.php';
require 'Database.php';

function infoCampagne($id, $db) {


    $mysqli = $db->getConnection();
    $sql_query = "SELECT * FROM campagne WHERE id=".$id."";
    $result = $mysqli->query($sql_query);
    $row = $result->fetch_assoc();

    $infoTab[0] = $row['limite'];
    $infoTab[1] = $row['waiting'];
    $infoTab[2] = $row['tracking'];


    return $infoTab;
}

function infoGlobalTest($id, $db) {


    $mysqli = $db->getConnection();
    $sql_query = "SELECT * FROM global_test WHERE id=".$id."";
    $result = $mysqli->query($sql_query);
    $row = $result->fetch_assoc();

    $infoTab[1] = $row['waiting'];

    $waiting = $row['waiting'];

    return $waiting;
}



function getEmailTest($id, $db) {


    $mysqli = $db->getConnection();
    $sql_query = "SELECT * FROM campagne WHERE id=".$id."";
    $result = $mysqli->query($sql_query);
    $row = $result->fetch_assoc();

    $emailTest = $row['emailTest'];

    return $emailTest;
}

function getTabIps($ipsTemp) {

    $i=0;
    $ips=array();
    foreach($ipsTemp as $ip)
    {
        $line = explode(',', $ip);
        $ips[$i][0]=$line[0];
        $ips[$i][1]=$line[1];
        $ips[$i][2]=$line[2];
        $ips[$i][3]=$line[3];
        $i=$i+1;
    }

    return $ips;
}


function verifyPause($chemin, $j, $id, $db)
{
    $pauseFile = fopen($chemin."pause.txt", 'r');
    $pause = fgets($pauseFile);
    if($pause=="1")
    {
        $mysqli = $db->getConnection();
        $sql = "UPDATE campagne SET numSent=numSent+".$j." WHERE id=".$id."";
        $result = $mysqli->query($sql);
        $sql = "UPDATE campagne SET numNoSent=numNoSent-".$j." WHERE id=".$id."";
        $result = $mysqli->query($sql);
        return true;
    }
    fclose($pauseFile);

    return false;

}


function majNumSent($chemin, $j)
{
    $numSentFile = fopen($chemin."numSent.txt", 'r');
    $numSent = fgets($numSentFile);
    fclose($numSentFile);
    $numNoSentFile = fopen($chemin."numNoSent.txt", 'r');
    $numNoSent = fgets($numNoSentFile);
    fclose($numNoSentFile);

    file_put_contents($chemin."numSent.txt", $numSent+$j);
    file_put_contents($chemin."numNoSent.txt", $numNoSent-$j);
}



function getMail($id, $chemin, $db) {

    $mysqli = $db->getConnection();
    $sql = "SELECT * FROM campagne WHERE id=".$id."";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
    $sql2 = "SELECT * FROM domaine WHERE id=".$row['domaine_id']."";
    $result2 = $mysqli->query($sql2);
    $row2 = $result2->fetch_assoc();

    $sql3 = "SELECT * FROM offre WHERE id=".$row['offre_id']."";
    $result3 = $mysqli->query($sql3);
    $row3 = $result3->fetch_assoc();

    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $file = fopen($chemin."log.txt","a");

    $html = $row['html'];
    $headers =  explode("\n", $row['header']);

    $lien = "http://".$row2['domaine']."/track.php?idEmail=0&type=1&idCamp=".$id;
    //$creative = "http://".$row2['domaine']."/track.php?idEmail=0&type=2&idCamp=".$id;
    $creative = "".$row3['creative']."";
    $unsub = "http://".$row2['domaine']."/track.php?idEmail=0&type=3&idCamp=".$id;
    $open = "http://".$row2['domaine']."/track.php?idEmail=0&type=2&idCamp=".$id;

    $html = str_replace("__lien",$lien,$html);
    $html = str_replace("__creative",$creative,$html);
    $html = str_replace("__unsub",$unsub,$html);
    $html = str_replace("__open",$open,$html);

    foreach ($headers  as  $header) {

        $pos = strpos($header, ":");
        $part1 = substr($header, 0, $pos);
        $part2 = substr($header, $pos+1);
        $part2 = trim($part2);


        switch ($part1) {
            case "FN":
                $mail->FromName = $part2;
                break;
            case "FE":
                $mail->From = $part2;
                break;
            case "SU":
                $mail->Subject = $part2;
                break;
            case "RT":
                $mail->AddReplyTo($part2);
                break;
            case "RP":
                $mail->Sender = $part2;
                break;
            case "MID":
                $part2 = str_replace("<","",$part2); $part2 =str_replace(">","",$part2);  $mail->MessageID = "<".$part2.">";
                break;
            default:
                $mail->addCustomHeader($header);

        }

    }


    switch ($row['encoding']) {
        case 1:
            $mail->Encoding = '8bit';
            break;
        case 2:
            $mail->Encoding = 'base64';
            break;
        case 3:
            $mail->Encoding = 'quoted-printable';
            break;
        case 4:
            $mail->Encoding = '7bit';
            break;
    }


    switch ($row['typeContent']) {
        case 1:
            $mail->Body = $html;
            $mail->IsHTML(true);
            break;
        case 2:
            $mail->Body = $html;
            break;
        case 3:
            $mail->msgHTML($html);
            break;
    }



    switch ($row['charset']) {
        case 1:
            $mail->CharSet = "utf-8";
            break;
        case 2:
            $mail->CharSet = "us-ascii";
            break;
        case 3:
            $mail->CharSet = "iso-8859-1";
            break;
    }


    return $mail;
}

function getTrackHtml($mail, $idEmail, $html) {

    $html = str_replace("idEmail=0&type=1","idEmail=".$idEmail."&type=1",$html);
    $html = str_replace("idEmail=0&type=2","idEmail=".$idEmail."&type=2",$html);
    $html = str_replace("idEmail=0&type=3","idEmail=".$idEmail."&type=3",$html);

    $mail->Body = $html;
    return $mail;

}




function getMailTestGlobal($id, $db) {

    $mysqli = $db->getConnection();
    $sql = "SELECT * FROM global_test WHERE id=".$id."";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
    /*$sql2 = "SELECT * FROM domaine WHERE id=".$row['domaine_id']."";
    $result2 = $mysqli->query($sql2);
    $row2 = $result2->fetch_assoc();*/

    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';

    $html = $row['html'];
    $headers =  explode("\n", $row['header']);


    foreach ($headers  as  $header) {

        $pos = strpos($header, ":");
        $part1 = substr($header, 0, $pos);
        $part2 = substr($header, $pos+1);
        $part2 = trim($part2);


        switch ($part1) {
            case "FN":
                $mail->FromName = $part2;
                break;
            case "FE":
                $mail->From = $part2;
                break;
            case "SU":
                $mail->Subject = $part2;
                break;
            case "RT":
                $mail->AddReplyTo($part2);
                break;
            case "RP":
                $mail->Sender = $part2;
                break;
            case "MID":
                $part2 = str_replace("<","",$part2); $part2 =str_replace(">","",$part2);  $mail->MessageID = "<".$part2.">";
                break;
            default:
                $mail->addCustomHeader($header);

        }

    }


    switch ($row['encoding']) {
        case 1:
            $mail->Encoding = '8bit';
            break;
        case 2:
            $mail->Encoding = 'base64';
            break;
        case 3:
            $mail->Encoding = 'quoted-printable';
            break;
        case 4:
            $mail->Encoding = '7bit';
            break;
    }


    switch ($row['typeContent']) {
        case 1:
            $mail->Body = $html;
            $mail->IsHTML(true);
            break;
        case 2:
            $mail->Body = $html;
            break;
        case 3:
            $mail->msgHTML($html);
            break;
    }



    switch ($row['charset']) {
        case 1:
            $mail->CharSet = "utf-8";
            break;
        case 2:
            $mail->CharSet = "us-ascii";
            break;
        case 3:
            $mail->CharSet = "iso-8859-1";
            break;
    }


    return $mail;
}