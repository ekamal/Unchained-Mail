<?php

namespace EK\MailBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CampagneSendType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            /*->add('nomCampagne', null, array(
                'label' => 'Nom Campagne'
            ))*/
            ->add('emailTest', null, array(
                'label' => 'Email Test'
            ))
            ->add('limite', null, array(
                'label' => 'Limit'
            ))
            ->add('waiting', null, array(
                'label' => 'Waiting'
            ))
            /*->add('tracking', 'choice', array(
                'label' => 'Tracking',
                'choices' => array('0' => 'Non' ,
                    '1' => 'Oui')
            ))*/
            ->add('header',"textarea", array(
                'label' => 'Header'
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
            ->add('html',"textarea", array(
                'label' => 'Html'
            ))
            ->add('datas' , 'entity', array(
                    'label'    => 'Data' ,
                    'attr' => array('class' => 'multiSelect'),
                    'class'    => 'MailBundle:Data',
                    'property' => 'nomData',
                    'multiple' => true)
            )
            /*->add('offre' , 'entity', array(
                    'label'    => 'Offre' ,
                    'class'    => 'MailBundle:Offre',
                    'property' => 'nomOffre',
                    'multiple' => false)
            )*/
            ->add('domaine' , 'entity', array(
                    'label'    => 'Domaine' ,
                    'class'    => 'MailBundle:Domaine',
                    'property' => 'domaine',
                    'multiple' => false)
            )
            ->add('ips' , 'entity', array(
                    'label'    => 'Ips' ,
                    'attr' => array('class' => 'multiSelect'),
                    'class'    => 'MailBundle:Ip',
                    'property' => 'ip',
                    'multiple' => true)
            )
            ->add('Test' , 'submit')
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EK\MailBundle\Entity\Campagne'
        ));
    }
}