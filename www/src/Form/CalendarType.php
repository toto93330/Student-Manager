<?php

namespace App\Form;


use App\Entity\Calendar;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class CalendarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('content', TextareaType::class, ['required' => true])
            ->add('start', DateTimeType::class, ['date_widget' => 'single_text', 'required' => true,])
            ->add('end', DateTimeType::class, ['date_widget' => 'single_text', 'required' => true,])
            ->add('allDay')
            ->add('background_color', ColorType::class, ['required' => true, 'row_attr' => ['id' => 'colorpicker-background']])
            ->add('border_color', ColorType::class, ['required' => true, 'row_attr' => ['id' => 'colorpicker-border']])
            ->add('text_color', ColorType::class, ['required' => true, 'row_attr' => ['id' => 'colorpicker-text']])
            ->add('student')
            ->add('validate');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Calendar::class,
        ]);
    }
}
