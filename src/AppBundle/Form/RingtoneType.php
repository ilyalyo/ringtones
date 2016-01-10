<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RingtoneType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, array('label' => 'Title'))
            ->add('price', null, array('label' => 'Price'))
            ->add('cover', 'vich_file', array(
                'label' => 'ringtone',
                'required' => false,
                'allow_delete' => true, // not mandatory, default is true
                'download_link' => true, // not mandatory, default is true
            ))
        ;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_ringtone';
    }
}
