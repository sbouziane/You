<?php

namespace App\Form;

use App\Entity\Search;
use App\Helpers\Constants;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('searchText', null, [
                'attr' => [
                    'class' => 'form-control searchtext',
                    'placeholder' => Constants::$siteConfig['search_input_placeholder'],
                ]
            ])
            ->add('search', SubmitType::class,
                ['attr'=> [
                    'class'=>'btn btn-default searchbut'
                ]
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Search::class,
        ]);
    }
}
