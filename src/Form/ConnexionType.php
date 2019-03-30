<?php

namespace App\Form;

use App\Entity\Contributor;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConnexionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('login',\Symfony\Component\Form\Extension\Core\Type\TextType::class,[
                'label' => 'Nom Utilisateur',
                'help' => 'Composé par des caractères spéciaux, alphanumériques',
                'required' => true
            ])
            ->add('pwd',PasswordType::class,[
                'label' => 'Mot de passe',
                'help' => 'Le mot de passe ne doit pas dépasser 10 caractères',
                'required' => true
            ])
            ->add('save',SubmitType::class,['label'=> 'Se connecter'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contributor::class,
        ]);
    }
}
