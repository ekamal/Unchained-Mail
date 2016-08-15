<?php

namespace EK\MailBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IpType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ip', null, array(
                'label' => 'IP'
            ))
            ->add('host', null, array(
                'label' => 'Host'
            ))
            ->add('username', null, array(
                'label' => 'Username'
            ))
            ->add('password', null, array(
                'label' => 'Password'
            ))
            ->add('Enregistrer' , 'submit')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EK\MailBundle\Entity\Ip'
        ));
    }
}
