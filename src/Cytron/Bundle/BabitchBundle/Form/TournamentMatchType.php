<?php

namespace Cytron\Bundle\BabitchBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

/**
 * GoalType Form class.
 */
class TournamentMatchType extends AbstractType
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
            ->add('blue_team', EntityType::class, array(
                'class' => 'CytronBabitchBundle:Team',
            ))
            ->add('red_team', EntityType::class, array(
                'class' => 'CytronBabitchBundle:Team',
            ))
            ->add('game', EntityType::class, array(
                'required' => false,
                'class' => 'CytronBabitchBundle:Game',
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Cytron\Bundle\BabitchBundle\Entity\Tournament\Match',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'tournament_match';
    }
}
