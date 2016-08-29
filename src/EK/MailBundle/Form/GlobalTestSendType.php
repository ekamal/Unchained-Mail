<?php

namespace EK\MailBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GlobalTestSendType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('emails',"textarea", array(
                'label' => 'Emails'
            ))
            ->add('header',"textarea", array(
                'label' => 'Header'
            ))
            ->add('html',"textarea", array(
                'label' => 'Html'
            ))
            ->add('waiting', null, array(
                'label' => 'Waiting'
            ))
            ->add('encoding', 'choice', array(
                'label' => 'Encoding',
                'choices' => array('1' => '8bit' ,'2' => 'base64','3' => 'quoted-printable','4' => '7bit')
            ))
            ->add('typeContent', 'choice', array(
                'label' => 'Type Content',
                'choices' => array('1' => 'Html' ,'2' => 'Text','3' => 'Multipart')
            ))
            ->add('charset', 'choice', array(
                'label' => 'Charset',
                'choices' => array('1' => 'utf-8' ,'2' => 'us-ascii','3' => 'iso-8859-1',)
            ))
            ->add('ips' , 'entity', array(
                    'label'    => 'Ips' ,
                    'attr' => array('class' => 'multiSelect'),
                    'class'    => 'MailBundle:Ip',
                    'property' => 'ip',
                    'multiple' => true)
            )
            ->add('Test Global' , 'submit')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EK\MailBundle\Entity\GlobalTest'
        ));
    }
}
