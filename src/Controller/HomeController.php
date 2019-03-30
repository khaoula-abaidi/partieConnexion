<?php

namespace App\Controller;

use App\Entity\Contributor;
use App\Entity\Document;
use App\Form\ConnexionType;
use App\Repository\ContributorRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home_page")
     * @return Response
     */
    public function index() : Response
    {
        $documents = $this-> getDoctrine()
            -> getRepository(Document::class)
            -> findAll();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'documents' => $documents
        ]);
    }
    /**
     * @Route("/connexion", name = "home_connexion")
     */
    public function connexion(ContributorRepository $repository, Request $request): Response
    {
      $form = $this->createForm(ConnexionType::class);

      $form->handleRequest($request);
      if($form->isSubmitted()&& $form->isValid()){
          $data = $form->getData();
          /**
           *Searching for contributor's having login && Pwd into the database
           * @var $contributor Contributor
           */
          $contributor = $repository->findOneBy([
              'login' => $data['login'],
              'pwd'   => $data['pwd']
          ]);
        if($contributor!==null){
            $this->addFlash('success','Authentification réussite');
            return $this->redirectToRoute('contributor_authentification');
        }
      }
     return $this->render('/home/connexion.html.twig',[
         'form' => $form->createView(),
     ]);
    }
}