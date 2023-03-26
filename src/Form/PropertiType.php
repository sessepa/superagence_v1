<?php

namespace App\Form;

use App\Entity\Properti;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertiType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('surface')
            ->add('rooms')
            ->add('bedrooms')
            ->add('floor')
            ->add('price')
            ->add('heat',ChoiceType::class,[
                'choices'=>$this->getChoices()
            ])
            ->add('city')
            ->add('adresse')
            ->add('sold')
            ->add('postalcode')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Properti::class,
            'translation_domain' => 'forms'
        ]);
    }
    private function getChoices(){
        $choices = Properti::HEAT;
        $ouput= [];
        foreach ($choices as $k=>$v){
            $ouput[$v] = $k;
        }
        return $ouput;

    }
}
