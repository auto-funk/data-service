<?php

namespace DataService\Form\Type;

use DataService\Model\Model;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ModelType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('metadata', new MetadataType())
            ->add('properties', 'collection', array(
                'type'      => new PropertyType(),
                'allow_add' => true,
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'      => 'DataService\Model\Model',
            'csrf_protection' => false,
            'empty_data'      => function (FormInterface $form) {
                return new Model(
                    $form->get('metadata')->getData(),
                    $form->get('properties')->getData()
                );
            }
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'model';
    }
}
