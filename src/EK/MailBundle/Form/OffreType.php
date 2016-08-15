<?php

namespace EK\MailBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OffreType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomOffre', null, array(
                'label' => 'Nom Offre'
            ))
            ->add('lien', null, array(
                'label' => 'Lien Offre'
            ))
            ->add('creative', null, array(
                'label' => 'Lien Creative'
            ))
            ->add('description',"textarea", array(
                'label' => 'Description'
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
            'data_class' => 'EK\MailBundle\Entity\Offre'
        ));
    }
}
