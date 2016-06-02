<?php

namespace Cytron\Bundle\BabitchBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

/**
 * GoalType Form class.
 */
class TeamType extends AbstractType
{
    /**
     * Configures a Team form.
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('player1', EntityType::class, array(
                // 'placeholder' => 'Select player',
                'class' => 'CytronBabitchBundle:Player',
                // 'choice_label' => 'name',
            ))
            ->add('player2', EntityType::class, array(
                // 'placeholder' => 'Select player',
                'class' => 'CytronBabitchBundle:Player',
                // 'choice_label' => 'name',
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Cytron\Bundle\BabitchBundle\Entity\Team',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'team';
    }
}
