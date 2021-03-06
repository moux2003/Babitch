<?php

namespace Cytron\Bundle\BabitchBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

/**
 * GoalType Form class.
 */
class TournamentGroupType extends AbstractType
{
    /**
     * Configures a Tournament form.
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('tournament', EntityType::class, array(
                'class' => 'CytronBabitchBundle:Tournament\Tournament',
            ))
            ->add('teams', EntityType::class, array(
                'class' => 'CytronBabitchBundle:Team',
                'multiple' => true,
                'expanded' => true,
                'choice_label' => 'name',
            ))
            ->add('matchs', CollectionType::class, array(
                'entry_type' => TournamentMatchType::class,
                'allow_add' => true,
                'by_reference' => false,
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Cytron\Bundle\BabitchBundle\Entity\Tournament\Group',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'tournament_group';
    }
}
