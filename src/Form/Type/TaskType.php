<?php

namespace App\Form\Type;

use App\Entity\Frequency;
use App\Entity\Room;
use App\Entity\Task;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [ 'label' => 'list.head.name' ])
            ->add('room', EntityType::class, [ 'class' => Room::class, 'choice_label' => 'name', 'label' => 'list.head.room' ])
            ->add('duration', IntegerType::class, [ 'label' => 'list.head.frequency' ])
            ->add('frequency', EntityType::class, [ 'class' => Frequency::class, 'choice_label' => 'name', 'label' => 'list.head.frequency' ])
            ->add('difficulty', IntegerType::class, [ 'label' => 'list.head.difficulty' ])
            ->add('lastDone', DateType::class, [ 'required' => false, 'label' => 'list.head.last_done' ])
            ->add('lastDoneBy', EntityType::class, [ 'class' => User::class, 'choice_label' => 'username', 'required' => false, 'label' => 'list.head.last_done_by' ])
            ->add('save', SubmitType::class, [ 'label' => 'form.save' ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
