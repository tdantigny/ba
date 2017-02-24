<?php
/**
 * Created by PhpStorm.
 * User: tegbessou
 * Date: 20/11/2016
 * Time: 19:04
 */

namespace AppBundle\Bo\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type as Filters;

/**
 * Class UserType
 * @package AppBundle\Bo\Form
 */
class YearBookFilterType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', Filters\TextFilterType::class, [
                'label' => 'Nom',
            ]);
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'guide_book_filter';
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