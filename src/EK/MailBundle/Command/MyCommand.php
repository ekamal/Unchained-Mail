<?php

namespace EK\MailBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


Class MyCommand extends ContainerAwareCommand{

    protected function configure()
    {
        $this
            ->setName('my:command')
            ->setDescription('comparer des répertoires de photo');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $logger=$this->getContainer()->get('logger');
        $logger->info('début de l execution de  la commande');

        for($i=0;$i<10;$i++) { $logger->info('execiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiii '.$i); sleep(5);}

        $logger->info('fin de l execution de  la commande');
    }
}