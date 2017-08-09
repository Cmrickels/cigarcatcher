<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CigarType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('body', TextType::class, array('attr' => array('class' => 'form-control'), 'required' => true))
            ->add('wrapperCountry', CountryType::class, array('attr' => array('class' => 'form-control'), 'required' => true))
            ->add('variant', TextType::class, array('attr' => array('class' => 'form-control'), 'required' => true))
            ->add('description', TextType::class, array('attr' => array('class' => 'form-control'), 'required' => true))
            ->add('fillerCountry', TextType::class, array('attr' => array('class' => 'form-control'), 'required' => true))
            ->add('image', FileType::class, array('attr' => array('class' => 'form-control'), 'required' => true, 'data_class' => null))
            ->add('manufacturer', EntityType::class, array('attr' => array('class' => 'form-control'), 'required' => true,
                    'class' => 'AppBundle:Manufacturer',
                    'choice_label' => 'name'
                )
            )
            ->add('wrapper', EntityType::class, array('attr' => array('class' => 'form-control'), 'required' => true,
                    'class' => 'AppBundle:Wrapper',
                    'choice_label' => 'name'
                )
            )
            ->add('shapes', EntityType::class, array('attr' => array('class' => 'form-control'), 'required' => true,
                    'class' => 'AppBundle:Shape',
                    'choice_label' => 'name',
                    'expanded' => true,
                    'multiple' => true
                )
            );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Cigar'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_cigar';
    }


}
