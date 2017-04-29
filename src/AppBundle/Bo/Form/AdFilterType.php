<?php

namespace AppBundle\Bo\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type as Filters;

/**
 * Class AdFilterType
 * @package AppBundle\Bo\Form
 */
class AdFilterType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', Filters\ChoiceFilterType::class, [
                'label' => 'Type',
                'choices' => [
                    'Footer' => 'footer',
                    'Header' => 'header',
                    'Wallpaper' => 'wallpaper',
                ],
            ])
            ->add('startDate', Filters\DateFilterType::class, [
                'label' => 'Date de début',
                'format' => 'dd MM y'
            ])
            ->add('endDate', Filters\DateFilterType::class, [
                'label' => 'Date de fin',
                'format' => 'dd MM y'
            ]);
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'ad_filter';
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection'   => false,
            'validation_groups' => array('filtering'),
        ]);
    }
}