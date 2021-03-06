<?php

namespace AppBundle\Bo\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class UserType
 * @package AppBundle\Bo\Form
 */
class UserModifyType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email',
            ])
            ->add('firstName', TextType::class, [
                'label' => 'Prénom',
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('civility', ChoiceType::class, [
                'choices'  => array(
                    'M' => 'M',
                    'Mme' => 'Mme',
                    'Mlle' => 'Mlle',
                ),
                'expanded' => true,
                'multiple' => false,
                'label' => 'Civilité',
            ])
            ->add('lastName', TextType::class, [
                'required' => true,
                'label' => 'Nom',
            ])
            ->add('firstName', TextType::class, [
                'required' => true,
                'label' => 'Prénom',
            ])
            ->add('birthDate', DateType::class, [
                'required' => true,
                'label' => 'Date de naissance',
            ])
            ->add('address1', TextType::class, [
                'required' => true,
                'label' => 'Adresse 1',
            ])
            ->add('address2', TextType::class, [
                'required' => false,
                'label' => 'Adresse 2',
            ])
            ->add('city', TextType::class, [
                'required' => true,
                'label' => 'Ville',
            ])
            ->add('zipCode', TextType::class, [
                'required' => true,
                'label' => 'Code postal',
            ])
            ->add('phoneNumber', TextType::class, [
                'required' => true,
                'label' => 'Téléphone',
            ]);
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'user_modify';
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection'   => false,
        ]);
    }
}
