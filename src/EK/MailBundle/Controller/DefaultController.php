<?php

namespace EK\MailBundle\Controller;

use EK\MailBundle\Entity\Bounce;
use EK\MailBundle\Entity\Campagne;
use EK\MailBundle\Entity\Data;
use EK\MailBundle\Entity\Domaine;
use EK\MailBundle\Entity\Email;
use EK\MailBundle\Entity\GlobalTest;
use EK\MailBundle\Entity\Ip;
use EK\MailBundle\Entity\Isp;
use EK\MailBundle\Entity\Offre;
use EK\MailBundle\Entity\Unsub;
use EK\MailBundle\Form\CampagneType;
use EK\MailBundle\Form\CampagneSendType;
use EK\MailBundle\Form\DataType;
use EK\MailBundle\Form\DomaineType;
use EK\MailBundle\Form\GlobalTestType;
use EK\MailBundle\Form\IpType;
use EK\MailBundle\Form\IspType;
use EK\MailBundle\Form\OffreType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Process\PhpProcess;
use Symfony\Component\Process\Process;
use Symfony\Component\Form\SubmitButton;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;


class DefaultController extends Controller
{


    //******************************* Fonction INDEX *******************************//


    public function indexAction()
    {
        return $this->render('MailBundle:Default:index.html.twig');
    }


    //******************************* Fonction AJOUTER IP *******************************//

    function ajouterIpAction(Request $request) {

        $ip = new Ip();
        $form = $this->createForm( new IpType(), $ip);
        $form->handleRequest($request);


        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ip);
            $em->flush();
            return $this->redirect($this->generateUrl("index"));
        }

        return $this->render('MailBundle:Default:ajouter.html.twig', array(
            'form' => $form->createView() ,
        ));


    }








    //******************************* Fonction AJOUTER ISP *******************************//

    function ajouterIspAction(Request $request) {

        $isp = new Isp();
        $form = $this->createForm( new IspType(), $isp);
        $form->handleRequest($request);


        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($isp);
            $em->flush();
            return $this->redirect($this->generateUrl("index"));
        }

        return $this->render('MailBundle:Default:ajouter.html.twig', array(
            'form' => $form->createView() ,
        ));


    }










    //******************************* Fonction AJOUTER DOMAINE *******************************//

    function ajouterDomaineAction(Request $request) {

        $domaine = new Domaine();
        $form = $this->createForm( new DomaineType(), $domaine);
        $form->handleRequest($request);


        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $domaine->setEtat(true);
            $em->persist($domaine);
            $em->flush();
            return $this->redirect($this->generateUrl("index"));
        }

        return $this->render('MailBundle:Default:ajouter.html.twig', array(
            'form' => $form->createView() ,
        ));


    }






    //******************************* Fonction AJOUTER OFFRE *******************************//

    function ajouterOffreAction(Request $request) {

        $offre = new Offre();
        $form = $this->createForm( new OffreType(), $offre);
        $form->handleRequest($request);


        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $offre->setEtat(true);
            $em->persist($offre);
            $em->flush();
            return $this->redirect($this->generateUrl("index"));
        }

        return $this->render('MailBundle:Default:ajouter.html.twig', array(
            'form' => $form->createView() ,
        ));


    }







    //************************ FONCTION AJOUTER DATA *********************//
    public function ajouterDataAction(Request $request)
    {
        set_time_limit(14400);

        $data = new Data();
        $form = $this->createFormBuilder()
            ->add('nomData', 'text', array(
                'label' => 'Nom Data'
            ))
            ->add('isp' , 'entity', array(
                    'label'    => 'Isp' ,
                    'class'    => 'MailBundle:Isp',
                    'property' => 'isp',
                    'multiple' => false)
            )
            ->add('emails', 'file', array(
                'label' =>'Fichier Emails',
                'attr' => array('class' => 'file'),
            ))
            ->add('Enregistrer' , 'submit')
            ->getForm();

        $form->handleRequest($request);

        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $data->setNomData($form->get('nomData')->getData());
            $data->setIsp($form->get('isp')->getData());
            $em->persist($data);

            $lignes = file($form->get('emails')->getData(), FILE_SKIP_EMPTY_LINES);

            foreach($lignes as $ligne)
            {

                $email = new Email();
                $email->setData($data);
                $email->setEmail(utf8_encode(trim($ligne)));
                $em->persist($email);

            }


            $em->flush();
            return $this->redirect($this->generateUrl("index"));
        }

        return $this->render('MailBundle:Default:ajouter.html.twig', array(
            'form' => $form->createView() ,
        ));
    }






    //************************ FONCTION AJOUTER BOUNCE *********************//
    public function ajouterBounceAction(Request $request)
    {
        set_time_limit(14400);

        $form = $this->createFormBuilder()
            ->add('isp' , 'entity', array(
                    'label'    => 'Isp' ,
                    'class'    => 'MailBundle:Isp',
                    'property' => 'isp',
                    'multiple' => false)
            )
            ->add('emails', 'file', array(
                'label' =>'Fichier Emails',
                'attr' => array('class' => 'file'),
            ))
            ->add('Enregistrer' , 'submit')
            ->getForm();

        $form->handleRequest($request);

        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $lignes = file($form->get('emails')->getData(), FILE_SKIP_EMPTY_LINES);
            foreach($lignes as $ligne)
            {

                $bounce = new Bounce();
                $bounce->setEmail($ligne);
                $bounce->setIsp($form->get('isp')->getData());
                $em->persist($bounce);

            }

            $em->flush();
            return $this->redirect($this->generateUrl("index"));
        }

        return $this->render('MailBundle:Default:ajouter.html.twig', array(
            'form' => $form->createView() ,
        ));
    }








    //************************ FONCTION AJOUTER UNSUBS *********************//
    public function ajouterUnsubsAction(Request $request)
    {
        set_time_limit(14400);

        $form = $this->createFormBuilder()
            ->add('isp' , 'entity', array(
                    'label'    => 'Isp' ,
                    'class'    => 'MailBundle:Isp',
                    'property' => 'isp',
                    'multiple' => false)
            )
            ->add('emails', 'file', array(
                'label' =>'Fichier Emails',
                'attr' => array('class' => 'file'),
            ))
            ->add('Enregistrer' , 'submit')
            ->getForm();

        $form->handleRequest($request);

        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $lignes = file($form->get('emails')->getData(), FILE_SKIP_EMPTY_LINES);
            foreach($lignes as $ligne)
            {

                $unsub = new Unsub();
                $unsub->setEmail($ligne);
                $unsub->setIsp($form->get('isp')->getData());
                $em->persist($unsub);

            }

            $em->flush();
            return $this->redirect($this->generateUrl("index"));
        }

        return $this->render('MailBundle:Default:ajouter.html.twig', array(
            'form' => $form->createView() ,
        ));
    }









    //******************************* Fonction AJOUTER CAMPAGNE *******************************//

    function ajouterCampagneAction(Request $request) {

        $campagne = new Campagne();
        $form = $this->createForm( new CampagneType(), $campagne);
        $form->handleRequest($request);


        if($form->isValid()) {
            $numEmails = 0;
            $em = $this->getDoctrine()->getManager();
            $campagne->setPause(true);
            $campagne->setClicks(0);
            $campagne->setOpens(0);
            $campagne->setUnsubs(0);
            $campagne->setNumSent(0);
            $campagne->setNumNoSent(0);
            $campagne->setDate(new \DateTime());
            $em->persist($campagne);
            $em->flush();

            $chemin = $this->container->get('kernel')->getRootdir().'/../web/logs/';
            $chemin = $chemin.$campagne->getId();
            mkdir($chemin);

            $fileEmails = $chemin."/emails.txt";
            $file = fopen($fileEmails,"a");

            for($i=0; $i<count($campagne->getDatas()); $i++)
            {
                foreach($campagne->getDatas()[$i]->getEmails() as $email)
                {
                    fwrite($file, $email->getEmail()."\n");
                    $numEmails = $numEmails +1;
                }
            }
            fclose($file);
            $campagne->setNumNoSent($numEmails);
            $em->flush();

            $fileNumSent = $chemin."/numSent.txt";
            $file = fopen($fileNumSent,"a");
            fwrite($file, $campagne->getNumSent()."\n");
            fclose($file);

            $fileNumNoSent = $chemin."/numNoSent.txt";
            $file = fopen($fileNumNoSent,"a");
            fwrite($file, $campagne->getNumNoSent()."\n");
            fclose($file);

            $filePause = $chemin."/pause.txt";
            $file = fopen($filePause,"a");
            fwrite($file, "1"."\n");
            fclose($file);

            $fileLog = $chemin."/log.txt";
            $file = fopen($fileLog,"a");
            fwrite($file, "Campagne Created at : ".date('l jS \of F Y h:i:s A')."\n");
            fclose($file);

            $fileIps = $chemin."/ips.txt";
            $file = fopen($fileIps,"a");
                foreach($campagne->getIps() as $ip)
                {
                    fwrite($file, $ip->getIp().",".$ip->getHost().",".$ip->getUsername().",".$ip->getPassword()."\n");
                }
            fclose($file);


            return $this->redirect($this->generateUrl("index"));
        }

        return $this->render('MailBundle:Default:ajouter.html.twig', array(
            'form' => $form->createView() ,
        ));


    }











    //******************************* Fonction AJOUTER GLOBAL TEST *******************************//

    function ajouterGlobalTestAction(Request $request) {

        $global = new GlobalTest();
        $form = $this->createForm( new GlobalTestType(), $global);
        $form->handleRequest($request);


        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $global->setDate(new \DateTime());
            $em->persist($global);
            $em->flush();




            $chemin = $this->container->get('kernel')->getRootdir().'/../web/globalTest/';
            $chemin = $chemin.$global->getId();
            mkdir($chemin);

            $fileEmails = $chemin."/emails.txt";
            $file = fopen($fileEmails,"a");

            $emails = explode(PHP_EOL, $global->getEmails());

                foreach($emails as $email)
                {
                    fwrite($file,$email."\n");
                }

            fclose($file);


            $fileIps = $chemin."/ips.txt";
            $file = fopen($fileIps,"a");
            foreach($global->getIps() as $ip)
            {
                fwrite($file, $ip->getIp().",".$ip->getHost().",".$ip->getUsername().",".$ip->getPassword()."\n");
            }
            fclose($file);


            return $this->redirect($this->generateUrl("index"));
        }

        return $this->render('MailBundle:Default:ajouter.html.twig', array(
            'form' => $form->createView() ,
        ));


    }









    //******************************* Fonction AFFICHER OFFRES *******************************//



    function afficherOffresAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $offres = $em->getRepository('MailBundle:Offre')->findAll();

        return $this->render('MailBundle:Default:afficherOffres.html.twig', array(
            'offres' => $offres ,
        ));


    }




    //******************************* Fonction AFFICHER DOMAINES *******************************//



    function afficherDomainesAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $domaines = $em->getRepository('MailBundle:Domaine')->findAll();

        return $this->render('MailBundle:Default:afficherDomaines.html.twig', array(
            'domaines' => $domaines ,
        ));


    }





    //******************************* Fonction AFFICHER IPS *******************************//



    function afficherIpsAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $ips = $em->getRepository('MailBundle:Ip')->findAll();

        return $this->render('MailBundle:Default:afficherIps.html.twig', array(
            'ips' => $ips ,
        ));


    }





    //******************************* Fonction AFFICHER ISPS *******************************//



    function afficherIspsAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $isps = $em->getRepository('MailBundle:Isp')->findAll();

        return $this->render('MailBundle:Default:afficherIsps.html.twig', array(
            'isps' => $isps ,
        ));


    }




    //******************************* Fonction AFFICHER DATA *******************************//



    function afficherDatasAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $datas = $em->getRepository('MailBundle:Data')->findAll();

        return $this->render('MailBundle:Default:afficherDatas.html.twig', array(
            'datas' => $datas ,
        ));


    }




    //******************************* Fonction AFFICHER CAMPAGNES *******************************//



    function afficherCampagnesAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $campagnes = $em->getRepository('MailBundle:Campagne')->findAll();

        return $this->render('MailBundle:Default:afficherCampagnes.html.twig', array(
            'campagnes' => $campagnes ,
        ));


    }





    //******************************* Fonction MODIFIER OFFRE *******************************//

    function modifierOffreAction(Request $request, Offre $offre) {

        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm( new OffreType(), $offre);
        $form->handleRequest($request);
        if($form->isValid()) {
            $em->flush();
            return $this->redirect($this->generateUrl("afficher_offres"));
        }

        return $this->render('MailBundle:Default:ajouter.html.twig', array(
            'form' => $form->createView() ,
        ));




    }










    //******************************* Fonction MODIFIER CAMPAGNE *******************************//

    function modifierCampagneAction(Request $request, Campagne $campagne) {

        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm( new CampagneType(), $campagne);
        $form->handleRequest($request);
        if($form->isValid()) {
            $em->flush();
            return $this->redirect($this->generateUrl("afficher_campagnes"));
        }

        return $this->render('MailBundle:Default:ajouter.html.twig', array(
            'form' => $form->createView() ,
        ));




    }






    //******************************* Fonction SUPPRIMER OFFRE *******************************//

    function supprimerOffreAction(Request $request, Offre $offre) {

        $em = $this->getDoctrine()->getManager();
        $em->remove($offre);
        $em->flush();
        $json = json_encode(array('id' => $offre->getId()));
        $response = new Response($json);
        return $response;

    }




    //******************************* Fonction SUPPRIMER DOMAINE *******************************//

    function supprimerDomaineAction(Request $request, Domaine $domaine) {

        $em = $this->getDoctrine()->getManager();
        $em->remove($domaine);
        $em->flush();
        $json = json_encode(array('id' => $domaine->getId()));
        $response = new Response($json);
        return $response;

    }





    //******************************* Fonction SUPPRIMER IP *******************************//

    function supprimerIpAction(Request $request, Ip $ip) {

        $em = $this->getDoctrine()->getManager();
        $em->remove($ip);
        $em->flush();
        $json = json_encode(array('id' => $ip->getId()));
        $response = new Response($json);
        return $response;

    }




    //******************************* Fonction SUPPRIMER ISP *******************************//

    function supprimerIspAction(Request $request, Isp $isp) {

        $em = $this->getDoctrine()->getManager();
        $em->remove($isp);
        $em->flush();
        $json = json_encode(array('id' => $isp->getId()));
        $response = new Response($json);
        return $response;

    }




    //******************************* Fonction SUPPRIMER DATA *******************************//

    function supprimerDataAction(Request $request, Data $data) {

        $em = $this->getDoctrine()->getManager();
        $em->remove($data);
        $em->flush();
        $json = json_encode(array('id' => $data->getId()));
        $response = new Response($json);
        return $response;

    }







    //******************************* Fonction SUPPRIMER CAMPAGNE *******************************//

    function supprimerCampagneAction(Request $request, Campagne $campagne) {

        //$chemin = $this->container->get('kernel')->getRootdir().'/../web/data/';
        //$chemin = $chemin.$campagne->getId().".txt";
        //unlink($chemin);

        $chemin = $this->container->get('kernel')->getRootdir().'/../web/logs/';
        $chemin = $chemin.$campagne->getId();
        $cheminEmails = $chemin."/emails.txt";
        $cheminIps = $chemin."/ips.txt";
        $cheminLog = $chemin."/log.txt";
        $cheminNumNoSent = $chemin."/numNoSent.txt";
        $cheminNumSent = $chemin."/numSent.txt";
        $cheminPause = $chemin."/pause.txt";
        unlink($cheminEmails);
        unlink($cheminIps);
        unlink($cheminLog);
        unlink($cheminNumNoSent);
        unlink($cheminNumSent);
        unlink($cheminPause);
        rmdir($chemin);

        $em = $this->getDoctrine()->getManager();
        $em->remove($campagne);
        $em->flush();



        $json = json_encode(array('id' => $campagne->getId()));
        $response = new Response($json);
        return $response;

    }








    //******************************* Fonction ETAT OFFRE *******************************//

    function etatOffreAction(Request $request, Offre $offre) {

        $em = $this->getDoctrine()->getManager();
        if($offre->getEtat())
        {
            $offre->setEtat(false);
        }
        else
        {
            $offre->setEtat(true);
        }



        $em->flush();
        $json = json_encode(array('id' => $offre->getId()));
        $response = new Response($json);
        return $response;

    }










    //******************************* Fonction ETAT DOMAINE *******************************//

    function etatDomaineAction(Request $request, Domaine $domaine) {

        $em = $this->getDoctrine()->getManager();
        if($domaine->getEtat())
        {
            $domaine->setEtat(false);
        }
        else
        {
            $domaine->setEtat(true);
        }



        $em->flush();
        $json = json_encode(array('id' => $domaine->getId()));
        $response = new Response($json);
        return $response;

    }









    //******************************* Fonction AFFICHER CAMPAGNE *******************************//

    /*function afficherCampagneAction(Request $request, Campagne $campagne) {

        $form = $this->createForm( new CampagneSendType(), $campagne);
        $form->handleRequest($request);
        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            if ($form->get('Send')->isClicked()) {

                chdir('C:\wamp\www\UnchainedMail\src\EK\MailBundle\Scripts');
                $cmd = "php -q send.php ".$campagne->getId()."";


                if(substr(php_uname(), 0, 7) == "Windows"){
                    pclose(popen("start /B ". $cmd, "r"));
                }else {
                    exec($cmd . " > /dev/null &");
                }

                return $this->render('MailBundle:Default:send.html.twig', array('id' => $campagne->getId()));

            }
            else {
                return $this->redirect($this->generateUrl('sending', array('id' => $campagne->getId(),'type' => 0)));
            }

        }
        return $this->render('MailBundle:Default:campagne.html.twig', array(
            'form' => $form->createView() ,
            'nomCampagne' => $campagne->getNomCampagne(),
        ));

    }*/


    //******************************* Fonction AFFICHER CAMPAGNE *******************************//

    function afficherCampagneAction(Request $request, Campagne $campagne) {

        return $this->render('MailBundle:Default:send.html.twig', array('campagne' => $campagne));

    }






    //******************************* Fonction SENDING *******************************//

    /*function sendingAction(Request $request, Campagne $campagne, $type) {


        $headers = explode(PHP_EOL, $campagne->getHeader());
        $xheaders = array();
        $fromName = null;
        $from = null;
        $subject = null;
        $replyTo = null;
        $sender = null;
        $messageID = null;
        $encoding = null;
        $typeContent = null;
        $charset = null;
        $html = $campagne->getHtml();

        $creative = "http://".$campagne->getDomaine()->getDomaine()."/track.php?id=".$campagne->getId()."&type=1";
        $lien = "http://".$campagne->getDomaine()->getDomaine()."/track.php?id=".$campagne->getId()."&type=2";
        $unsub = "http://".$campagne->getDomaine()->getDomaine()."/track.php?id=".$campagne->getId()."&type=3";

        $html = str_replace("__creative",$creative,$html);
        $html = str_replace("__lien",$lien,$html);
        $html = str_replace("__unsub",$unsub,$html);


        foreach ($headers  as  $header) {

            $pos = strpos($header, ":");
            $part1 = substr($header, 0, $pos);
            $part2 = substr($header, $pos+1);


            switch ($part1) {
                case "FN":
                    //$mail->FromName = $part2;
                    $fromName = $part2;
                    break;
                case "FE":
                    //$mail->From = $part2;
                    $from = $part2;
                    break;
                case "SU":
                    //$mail->Subject = $part2;
                    $subject = $part2;
                    break;
                case "RT":
                    //$mail->AddReplyTo($part2);
                    $replyTo = $part2;
                    break;
                case "RP":
                    //$mail->Sender = $part2;
                    $sender = $part2;
                    break;
                case "MID":
                    $part2 = str_replace("<","",$part2); $part2 =str_replace(">","",$part2); $messageID = "<".$part2.">"; // $mail->MessageID = "<".$part2.">";
                    break;
                default:
                    //$mail->addCustomHeader($header);
                    array_push($xheaders, $header);

            }

        }


        switch ($campagne->getEncoding()) {
            case 1:
                //$mail->Encoding = '8bit';
                $encoding = "8bit";
                break;
            case 2:
                //$mail->Encoding = 'base64';
                $encoding = "base64";
                break;
            case 3:
                //$mail->Encoding = 'quoted-printable';
                $encoding = "quoted-printable";
                break;
            case 4:
                //$mail->Encoding = '7bit';
                $encoding = "7bit";
                break;
        }


        switch ($campagne->getTypeContent()) {
            case 1:
                //$mail->Body = $_POST['bodyHtml'];
                //$mail->IsHTML(true);
                $typeContent = "html";
                break;
            case 2:
                //$mail->Body = $_POST['bodyHtml'];
                $typeContent = "text";
                break;
            case 3:
                //$mail->msgHTML($_POST['bodyHtml']);
                $typeContent = "multipart";
                break;
        }


        switch ($campagne->getCharset()) {
            case 1:
                //$mail->CharSet = "utf-8";
                $charset = "utf-8";
                break;
            case 2:
                //$mail->CharSet = "us-ascii";
                $charset = "us-ascii";
                break;
            case 3:
                //$mail->CharSet = "iso-8859-1";
                $charset = "iso-8859-1  ";
                break;
        }





        if($type==0)
        {
            return $this->sendingTest($fromName, $from, $subject, $replyTo, $sender, $messageID, $encoding, $typeContent, $charset, $html, $xheaders, $campagne);
        }
        else
        {
            return $this->sendingSend($fromName, $from, $subject, $replyTo, $sender, $messageID, $encoding, $typeContent, $charset, $html, $xheaders, $campagne);

        }





    }*/




    /*function sendingTest($fromName, $from, $subject, $replyTo, $sender, $messageID, $encoding, $typeContent, $charset, $html, $xheaders, Campagne $campagne) {

        $hess = array();

        if (isset($fromName)) {
            array_push($hess, $fromName);
        }
        if (isset($from)) {
            array_push($hess, $from);
        }
        if (isset($subject)) {
            array_push($hess, $subject);
        }
        if (isset($replyTo)) {
            array_push($hess, $replyTo);
        }
        if (isset($sender)) {
            array_push($hess, $sender);
        }
        if (isset($messageID)) {
            array_push($hess, $messageID);
        }
        if (isset($encoding)) {
            array_push($hess, $encoding);
        }
        if (isset($typeContent)) {
            array_push($hess, $typeContent);
        }
        if (isset($charset)) {
            array_push($hess, $charset);
        }



        return $this->render('MailBundle:Default:test.html.twig', array(
            'hess' => $hess,
            'html' => $html,
            'xheaders' => $xheaders,
            'campagne' => $campagne));


    }*/




    /*function sendingSend($fromName, $from, $subject, $replyTo, $sender, $messageID, $encoding, $typeContent, $charset, $html, $xheaders, Campagne $campagne) {

        $hess = array();
        date_default_timezone_set('Etc/UTC');

        if (isset($fromName)) {
            array_push($hess, $fromName);
        }
        if (isset($from)) {
            array_push($hess, $from);
        }
        if (isset($subject)) {
            array_push($hess, $subject);
        }
        if (isset($replyTo)) {
            array_push($hess, $replyTo);
        }
        if (isset($sender)) {
            array_push($hess, $sender);
        }
        if (isset($messageID)) {
            array_push($hess, $messageID);
        }
        if (isset($encoding)) {
            array_push($hess, $encoding);
        }
        if (isset($typeContent)) {
            array_push($hess, $typeContent);
        }
        if (isset($charset)) {
            array_push($hess, $charset);
        }

        $chemin = $this->container->get('kernel')->getRootdir().'/../web/data/';
        $chemin = $chemin.$campagne->getId().".txt";
        $emails  = file($chemin, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $i =0;
        $log = $this->container->get('kernel')->getRootdir().'/../web/logs/';
        $log = $log.$campagne->getId().".txt";
        $fileLog = fopen($log,"a");
        fwrite($fileLog, "ttttttttt"."\n");*/



        //$process->start();


            //$output = $file2[0];
            //unset($file2[0]);
            //file_put_contents($chemin, implode("\r\n", $file2));


        /*$em = $this->getDoctrine()->getManager();
        while(!empty($emails))
        {
            $numNoSent = $campagne->getNumNoSent();
            $numNoSent = $numNoSent -1;
            $campagne->setNumNoSent($numNoSent);

            $numSent = $campagne->getNumSent();
            $numSent = $numSent +1;
            $campagne->setNumSent($numSent);
            $em->flush();

            usleep(2000000);


            $output = $emails[$i];
            unset($emails[$i]);
            $i = $i+1;
            fwrite($fileLog, $output." a ".date("H:i:s")."\n");

        }*/
        /*fclose($fileLog);




        $json = json_encode(array('id' => $campagne->getId()));
        $response = new Response($json);
        return $response;


    }*/









    //******************************* Fonction NUMSEND *******************************//

    function numSendAction(Request $request, Campagne $campagne) {


        $chemin = $this->container->get('kernel')->getRootdir().'/../web/logs/'.$campagne->getId()."/";
        $numSentFile = fopen($chemin."numSent.txt", 'r');
        $numSent = fgets($numSentFile);

        $chemin = $this->container->get('kernel')->getRootdir().'/../web/logs/'.$campagne->getId()."/";
        $numNoSentFile = fopen($chemin."numNoSent.txt", 'r');
        $numNoSent = fgets($numNoSentFile);


        $json = json_encode(array('numNoSent' => $numNoSent, 'numSent' => $numSent ));
        $response = new Response($json);
        return $response;

    }



    //******************************* Fonction SEND CAMPAGNE *******************************//

    function sendCampagneAction(Request $request, Campagne $campagne) {




        $em = $this->getDoctrine()->getManager();
        $campagne->setPause(false);
        $em->flush();

        $chemin = $this->container->get('kernel')->getRootdir().'/../web/logs/';
        $chemin = $chemin.$campagne->getId()."/pause.txt";
        file_put_contents($chemin, "0");

        chdir('C:\wamp\www\Symfony-Projects\Unchained-Mail\src\EK\MailBundle\Scripts');
        $cmd = "php -q send.php ".$campagne->getId()."";


        if(substr(php_uname(), 0, 7) == "Windows"){
            pclose(popen("start /B ". $cmd, "r"));
        }else {
            exec($cmd . " > /dev/null &");
        }

        return new Response();




    }


    //******************************* Fonction PAUSE SEND *******************************//

    function stopSendAction(Request $request, Campagne $campagne) {


        $em = $this->getDoctrine()->getManager();
        $campagne->setPause(true);
        $em->flush();
        $chemin = $this->container->get('kernel')->getRootdir().'/../web/logs/';
        $chemin = $chemin.$campagne->getId()."/pause.txt";

        file_put_contents($chemin, "1");
        return new Response();

    }







    //******************************* Fonction TEST CAMPAGNE *******************************//

    function testCampagneAction(Request $request, Campagne $campagne) {

        $form = $this->createForm( new CampagneSendType(), $campagne);
        $form->handleRequest($request);
        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();


            $chemin = $this->container->get('kernel')->getRootdir().'/../web/logs/';
            $chemin = $chemin.$campagne->getId();
            $fileIps = $chemin."/ips.txt";
            $file = fopen($fileIps,"w+");

            foreach($campagne->getIps() as $ip)
            {
                fwrite($file, $ip->getIp().",".$ip->getHost().",".$ip->getUsername().",".$ip->getPassword()."\n");
            }
            fclose($file);


            $em->flush();

            chdir('C:\wamp\www\Symfony-Projects\Unchained-Mail\src\EK\MailBundle\Scripts');
            $cmd = "php -q test.php ".$campagne->getId()."";


            if(substr(php_uname(), 0, 7) == "Windows"){
                pclose(popen("start /B ". $cmd, "r"));
            }else {
                exec($cmd . " > /dev/null &");
            }

            return $this->redirect($this->generateUrl('afficher_campagne', array('id' => $campagne->getId())));



        }
        return $this->render('MailBundle:Default:campagne.html.twig', array(
            'form' => $form->createView() ,
            'nomCampagne' => $campagne->getNomCampagne(),
        ));

    }













    //******************************* Fonction AFFICHER QUEUE *******************************//

    function afficherQueueAction(Request $request, Campagne $campagne) {

        $ips=array();
        foreach($campagne->getIps() as $ip) {

            $i = $ip->getIp();

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://".$i.":5771/deferred.php");
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERPWD, "kira:speedy15$");
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

            $output = curl_exec($ch);
            curl_close($ch);

            $ips[$i] = intval($output);
        }




        return $this->render('MailBundle:Default:queue.html.twig', array(
            'ips' => $ips));

    }











    //******************************* Fonction QUEUE SOLO *******************************//

    function queueSoloAction($ip) {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://".$ip.":5771/deferred.php");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, "kira:speedy15$");
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

        $output = curl_exec($ch);
        curl_close($ch);


        $json = json_encode(array('value' =>  intval($output)));
        $response = new Response($json);
        return $response;

    }













}
