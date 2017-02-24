<?php

namespace AppBundle\Bo\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type as Filters;

/**
 * Class UserType
 * @package AppBundle\Bo\Form
 */
class YearBookType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('active', CheckboxType::class, [
                'label' => 'Actif',
            ])
            ->add('slogan', TextType::class, [
                'label' => 'Slogan',
            ])
            ->add('url', TextType::class, [
                'label' => 'Url du site',
            ])
            ->add('picture', FileType::class, [
                'label' => 'Image',
            ])
            ->add('html', TextareaType::class, [
                'label' => 'Contenu du guide',
                'attr' => [
                    'class' => 'tinymce',
                    'data-theme' => 'bbcode', // Skip it if you want to use default theme
                ],
            ])
            ->add('paiementsMethod', EntityType::class, [
                'label' => 'Moyens de paiement',
                'class' => 'AppBundle:PaiementMethod',
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ]);
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'year_book';
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Core\Entity\YearBook',
        ]);
    }
}
