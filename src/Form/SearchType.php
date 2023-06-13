<?php

namespace App\Form;
/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Classe\Search;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Category;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
/**
 * Description of SearchType
 *
 * @author constancelaloux
 */
class SearchType extends AbstractType 
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('string', TextType::class,[
                    'label' => 'Rechercher',
                    'required' => false,
                    'attr' => [
                        'placeholder' => 'Votre recherche',
                        'class' => 'form-control-sm'
                        ]
                ])
            ->add('categories', EntityType::class,[
                'label' => false,
                'required' => false,
                'class' => Category::class,
                'multiple' => 'true',
                'expanded' => 'true'  
            ])
            ->add('submit', SubmitType::class,[
                'label' => 'Filtrer',
                'attr' => [
                    'class' => 'btn-block btn-info'
                ]
            ]);
    }
    
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Search::class,
            'method' => 'GET',
            'crsf_protection' => false,
        ]);
    }
    
    public function getBlockPrefix(): string
    {
        return "";
    }
}
