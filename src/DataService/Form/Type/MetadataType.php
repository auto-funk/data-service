<?php

namespace DataService\Form\Type;

use DataService\Model\Metadata;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MetadataType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'      => 'DataService\Model\Metadata',
            'csrf_protection' => false,
            'empty_data'      => function (FormInterface $form) {
                return new Metadata(
                    $form->get('name')->getData(),
                    $form->get('description')->getData()
                );
            }
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'metadata';
    }
}
