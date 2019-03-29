<?php

namespace App\Controller;

use App\Entity\Contributor;
use App\Form\ContributorType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContributorController extends AbstractController
{
    /**
     * Create a new Contributor using a Form
     * @Route("contributor/create", name="contributor_create_index")
     * @return Response
     */
    public function create(Request $request) :Response
    {
        $em = $this->getDoctrine()->getManager();
        $contributor = new Contributor();
        $form = $this->createForm(ContributorType::class, $contributor)
        //$form = $this->createForm($contributor)
            ->add('login',TextType::class,['label' => 'Login'])
            ->add('pwd',PasswordType::class,['label' => 'Mot de Passe'])
            ->add('civility',TextType::class,['label' => 'Civilité'])
            ->add('lastname',TextType::class,['label' => 'Nom'])
            ->add('firstname',TextType::class,['label' => 'Prénom'])
            ->add('complementName',TextType::class,['label' => 'Complément du Nom'])
            ->add('email',EmailType::class,['label' => 'Courrier Electronique'])
            ->add('isAdmin',RadioType::class,['label' => 'Accès Administrateur'])
            ->add('photo',FileType::class,['label' => 'Photo de Profil'])
        ->add('save',SubmitType::class,['label'=>'Créer un compte']);

        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
            $data = $form->getData();dump($data);
            $contributor->setLogin($data['login'])
                        ->setPwd($data['pwd'])
                        ->setCivility($data['civility'])
                        ->setLastname($data['lastname'])
                        ->setFirstname($data['firstname'])
                        ->setComplementName($data['complementName'])
                        ->setEmail($data['email'])
                        ->setIsAdmin($data['isAdmin'])
                        ->setPhoto($data['photo']);
            $em->persist($contributor);
            dump($contributor);
            $em->flush();
            $email = $contributor->getEmail();
            return $this->redirectToRoute('contributor_create_confirmation',[
                'email' => $email
            ]);
        }
        return $this->render('contributor/create.html.twig', [
            'controller_name' => 'ContributorController',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("contributor/create/confirmation", name = "contributor_create_confirmation")
     * @return Response
     */
    public function confirmation(Contributor $contributor) : Response
    {
        return $this->render('contributor/confirmation.html.twig',[
            'email' => $contributor->getEmail()
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
