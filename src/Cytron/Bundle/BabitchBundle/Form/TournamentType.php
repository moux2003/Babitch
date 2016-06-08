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
class TournamentType extends AbstractType
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
            ->add('teams', EntityType::class, array(
                'class' => 'CytronBabitchBundle:Team',
                'multiple' => true,
                'expanded' => true,
                'choice_label' => 'name',
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Cytron\Bundle\BabitchBundle\Entity\Tournament',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'tournament';
    }
}
