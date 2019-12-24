<?php

namespace App\Form;

use App\Entity\Medecin;
use App\Entity\Specialite;
use Doctrine\Common\Collections\Selectable;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class MedecinEditType extends MedecinType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('matricule' , HiddenType::class, [
                'disabled' => 'true'])
            ->add('prenom')
            ->add('nom')
            ->add('tel')
            ->add('dateNaissance')
            ->add('service')
            ->add('specialites' ,EntityType::class,['class'=>Specialite::class,'choice_label'=>'libelle','multiple'=>'true'])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Medecin::class,
        ]);
    }
}
