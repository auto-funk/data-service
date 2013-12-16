<?php

namespace DataService\Model;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PropertyType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('type')
            ->add('description')
            ->add('pattern')
            ->add('format')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'      => 'DataService\Model\Property',
            'csrf_protection' => false,
            'empty_data'      => function (FormInterface $form) {
                return new Property(
                    $form->get('name')->getData(),
                    $form->get('type')->getData(),
                    $form->get('description')->getData(),
                    $form->get('pattern')->getData(),
                    $form->get('format')->getData()
                );
            }
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'property';
    }
}
