<?php

namespace AppBundle\Fo\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

/**
 * Class RegistrationType
 * @package AppBundle\Fo\Form
 */
class RegistrationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'required' => true,
            ])
            ->add('enableNewsletter', CheckboxType::class, [
                'required' => false,
                'label' => 'Newsletter',
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les deux mots de passe ne correspondent pas.',
                'options' => array('attr' => array('class' => 'password-field')),
                'required' => true,
                'first_options'  => array('label' => 'Mot de passe'),
                'second_options' => array('label' => 'Confirmation mot de passe'),
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
                'required' => true,
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
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Core\Entity\Users',
        ]);
    }
}