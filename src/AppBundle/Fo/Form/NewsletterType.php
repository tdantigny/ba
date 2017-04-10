<?php

namespace AppBundle\Fo\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class NewsletterType
 * @package AppBundle\Form
 */
class NewsletterType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'email',
                EmailType::class,
                [
                    'required' => true,
                ]
            )
            ->add('zipCode',
                TextType::class,
                [
                    'required' => true,
                    'label' => 'Code postal',
                ]
            )
            ->add('lastName',
                TextType::class,
                [
                    'required' => true,
                    'label' => 'Nom',
                ]
            )
            ->add('firstName',
                TextType::class,
                [
                    'required' => true,
                    'label' => 'Prénom',
                ]
            )
            ->add('birthDate',
                BirthdayType::class,
                [
                    'required' => true,
                    'label' => 'Date de naissance',
                    'format' => 'dd MM y'
                ]
            )
            ->add(
                'Je m\'inscris',
                SubmitType::class
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Core\Entity\Users',
        ]);
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'app_bundle_newsletter_type';
    }
}
