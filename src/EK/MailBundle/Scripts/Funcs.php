<?php

//date_default_timezone_set('Etc/UTC');
require 'PHPMailer/PHPMailerAutoload.php';

function verifyPause($chemin, $j, $id)
{
    $pauseFile = fopen($chemin."pause.txt", 'r');
    $pause = fgets($pauseFile);
    if($pause=="1")
    {
        $conn = new mysqli('localhost', 'root', '', 'ekmail');
        $sql = "UPDATE campagne SET numSent=numSent+".$j." WHERE id=".$id."";
        $result = $conn->query($sql);
        $sql = "UPDATE campagne SET numNoSent=numNoSent-".$j." WHERE id=".$id."";
        $result = $conn->query($sql);
        $conn->close();
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



function getMail($id, $chemin) {

    $conn = new mysqli('localhost', 'root', '', 'ekmail');
    $sql = "SELECT * FROM campagne WHERE id=".$id."";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $sql2 = "SELECT * FROM domaine WHERE id=".$row['domaine_id']."";
    $result2 = $conn->query($sql2);
    $row2 = $result2->fetch_assoc();
    $conn->close();

    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $file = fopen($chemin."log.txt","a");

    $html = $row['html'];
    $headers =  explode("\n", $row['header']);

    $creative = "http://".$row2['domaine']."/track.php?id=".$id."&type=1";
    $lien = "http://".$row2['domaine']."/track.php?id=".$id."&type=2";
    $unsub = "http://".$row2['domaine']."/track.php?id=".$id."&type=3";

    $html = str_replace("__creative",$creative,$html);
    $html = str_replace("__lien",$lien,$html);
    $html = str_replace("__unsub",$unsub,$html);

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