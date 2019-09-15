<?php

namespace App\Form;

use App\Entity\Gif;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GifType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('link')
            ->add('tag')
            ->add('album')
        ;
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            array($this, 'preSetData')
        );
    }

    public function preSetData(FormEvent $event)
    {

        $form = $event->getForm();
        $gif = $event->getData();
        if($gif->getId() === null){
            $form->add('submit', SubmitType::class, ['label_format' => 'Créer']);
        }else{
            $form->add('submit', SubmitType::class, ['label_format' => 'Editer']);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Gif::class,
        ]);
    }
}
