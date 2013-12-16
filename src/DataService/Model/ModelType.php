<?php

namespace DataService\Model;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ModelType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('metadata', new MetadataType())
                ->add('properties', 'collection', array(
                        'type'  => 'text',
                        'options'   => array(
                            'label'  =>  new PropertyType()
                        ),
                        'allow_add' => true
                     ));
//                ->add('filters', 'collection', );
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DataService\Model\Model',
            'csrf_protection' => false,
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
