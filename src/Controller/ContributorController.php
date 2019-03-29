<?php

namespace App\Controller;

use App\Entity\Contributor;
use App\Form\ContributorType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContributorController extends AbstractController
{
    /**
     * @Route("contributor/create", name="contributor_create_index")
     */
    public function create(Request $request) :Response
    {
        $em = $this->getDoctrine()->getManager();
        $contributor = new Contributor();
        $form = $this->createForm(ContributorType::class, $contributor)
            ->add('login',TextType::class,['label' => 'Login'])
            ->add('pwd',PasswordType::class,['label' => 'Mot de Passe'])
            ->add('civility',TextType::class,['label' => 'Civilité'])
            ->add('lastname',TextType::class,['label' => 'Nom'])
            ->add('firstname',TextType::class,['label' => 'Prénom'])
            ->add('complementName',TextType::class,['label' => 'Complément du Nom'])
            ->add('email',EmailType::class,['label' => 'Courrier Electronique'])
            ->add('isAdmin',RadioType::class,['label' => 'Accès Administrateur'])
            ->add('photo',FileType::class,['label' => 'Photo de Profil']);

        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
            $em->persist($contributor);
            $em->flush();
        }
        return $this->render('contributor/create.html.twig', [
            'controller_name' => 'ContributorController',
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("contributor/{id}/edit",  name = "contributor_edit")
     */
    public function edit(Contributor $contributor){
        //$entityManager = $this->getDoctrine()->getManager();
        //$contributor = $entityManager->getRepository(Contributor::class)->find($id);

        if (!$contributor) {
            throw $this->createNotFoundException(
                'No contributor found for id '.$contributor->getId()
            );
        }

        $contributor->setLogin('abaidik');
        $this->flush();

        return $this->redirectToRoute('contributor_show', [
            'id' => $contributor->getId()
        ]);
    }
}
