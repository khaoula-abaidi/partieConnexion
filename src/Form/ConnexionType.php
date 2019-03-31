<?php

namespace App\Form;

use App\Entity\Contributor;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

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
                'help' => 'Login est obligatoire',
                'required' => true,
                 'constraints' => [new Length(['min' => 1])]

            ])
            ->add('pwd',PasswordType::class,[
                'label' => 'Mot de passe',
                'help' => 'Mot de passe est obligatoire',
                'required' => true,
                 'constraints' => [new Length(['min' => 1])]
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
