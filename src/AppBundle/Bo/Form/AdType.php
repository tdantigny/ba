<?php

namespace AppBundle\Bo\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AdType
 * @package AppBundle\Bo\Form
 */
class AdType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'Type',
                'choices' => [
                    'Footer' => 'footer',
                    'Header' => 'header',
                    'Wallpaper' => 'wallpaper',
                ],
            ])
            ->add('picture', FileType::class, [
                'label' => 'Image',
            ])
            ->add('link', TextType::class, [
                'label' => 'Lien',
            ])
            ->add('startDate', DateType::class, [
                'label' => 'Date de début',
                'format' => 'dd MM y'
            ])
            ->add('endDate', DateType::class, [
                'label' => 'Date de fin',
                'format' => 'dd MM y'
            ])
            ->add('enable', CheckboxType::class, [
                'label' => 'Actif',
                'required' => false,
            ]);
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'ad_modify';
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Core\Entity\Ad',
        ]);
    }
}
