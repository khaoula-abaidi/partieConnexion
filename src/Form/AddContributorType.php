<?php

namespace App\Form;

use App\Entity\Contributor;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddContributorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('civility',TextType::class,[
                                         'label'=> 'Civilité',
                                         'help' => 'Mr, Mme,...',
                                         ])
            ->add('lastname',TextType::class,[
                                          'label'=> 'Prénom',
                                        ])
            ->add('firstname',TextType::class,[
                                        'label'=> 'Nom',
                                         ])
            ->add('complementName',TextType::class,[
                                        'label'=> 'Complément du Nom',
                                        ])
            ->add('email',EmailType::class,[
                                        'label'=> 'Courrier Electronique',
                                        ])
            ->add('isAdmin',RadioType::class,[
                                         'label'=> 'Accès Administrateur ? ',
                                         ])
            ->add('photo', FileType::class,[
                                         'label'=> 'Uploader une image de profil',
                                        ])
            ->add('login', TextType::class,[
                                                    'label'=> 'Login',
                                                    'help' => 'Le login doit être composé par des caractères spéciaux',
                                                    'required' => true
                                             ])
            ->add('pwd',PasswordType::class,[
                                                  'label'=> 'Mot de passe',
                                                  'help' => 'Le mot de passe doit dépasser 10 caractères',
                                                  'required' => true
                                             ])
            ->add('save',SubmitType::class,[
                'label'=> 'Confirmer'
            ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contributor::class,
        ]);
    }
}
