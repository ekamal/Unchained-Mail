<?php

namespace EK\MailBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DataType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomData', null, array(
                'label' => 'Nom Data'
            ))
            ->add('typeData', null, array(
                'label' => 'Type Data'
            ))
            ->add('emailss', 'file', array(
                'label' =>'Fichier Emails',
                'attr' => array('class' => 'file'),
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
            'data_class' => 'EK\MailBundle\Entity\Data'
        ));
    }
}
