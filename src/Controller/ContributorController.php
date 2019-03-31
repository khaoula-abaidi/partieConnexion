<?php

namespace App\Controller;
use App\Entity\Contributor;
use App\Form\AddContributorType;
use App\Repository\ContributorRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContributorController extends AbstractController
{
    /**
     * @Route("/contributor/create", name ="contributor_create_index")
     * @return Response
     */
    public function create(Request $request, ObjectManager $manager) : Response
    {
        $form  = $this->createForm(AddContributorType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $data = $form->getData();
            /**
             * @var $contributor Contributor
             */
            $contributor = new Contributor();
            $contributor = $data;
            /*
            $contributor->setCivility($data['civility']);
            $contributor->setFirstname($data['firstname']);
            $contributor          ->setLastname($data['lastname']);
            $contributor         ->setComplementName($data['complementName']);
            $contributor        ->setEmail($data['email']);
            $contributor        ->setPhoto($data['photo']);
            $contributor        ->setLogin($data['login']);
            $contributor        ->setPwd($data['pwd']);
            $contributor        ->setIsAdmin($data['isAdmin']);
             */
           $manager->persist($contributor);
           $manager->flush();
            $this->addFlash('success','Votre compte est crée');
            return $this->render('contributor/confirmation.html.twig', [
                'email'=> $contributor->getEmail()]);
        }
            return $this->render('/contributor/creation.html.twig',[
            'form' => $form->createView(),
            ]);
    }
    /**
     * @Route("/contributor/create/confirmation", name ="contributor_creation_confirmation")
     * @return Response
     */
    public function confirmation(): Response{
        return $this->render('contributor/confirmation.html.twig');
    }
    /**
     * @Route("/contributor/{id}", name="contributor_authentification")
     */
    public function show($id)
    {
        $contributor = $this->getDoctrine()->getRepository(Contributor::class)->find($id);
        if(!$contributor){
            return $this->render('contributor/error.html.twig');
        }
        return $this->render('contributor/index.html.twig', [
            'controller_name' => 'ContributorController',
            'contributor' => $contributor
        ]);
    }

    /**
     * Listing All document(s related to contributor's having id $id
     * @Route("/contributor/{id}/documents", name ="contributor_listing")
     * @return Response
     */
    public function listing($id) : Response
    {
        $documents = $this->getDoctrine()->getManager()
                      ->getRepository(Contributor::class)->find($id)->getDocuments();
        dump($documents);
        return $this->render('contributor/documents.html.twig', [
            'id'=> $id,
            'documents' => $documents]);
    }
}
