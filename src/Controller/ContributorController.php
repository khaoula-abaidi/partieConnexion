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
     * @Route("/contributor/create", name ="contributor_create")
     * @return Response
     */
    public function create(Request $request, ObjectManager $manager) : Response
    {
        $form = $this->createForm(AddContributorType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $data = $form->getData();
            /**
             * @var $contributor Contributor
             */
            $contributor = new Contributor();
            $contributor->setCivility('Mme');
            $contributor->setFirstname('khaoula');
            $contributor->setLastname('abaidi');
            $contributor->setComplementName('gachtouta');
             $contributor          ->setEmail('abaidik@gmail.com');
                $contributor       ->setPhoto('dd.jpeg');
                  $contributor     ->setLogin('lolo');
                   $contributor    ->setPwd('llll');
                   $contributor    ->setIsAdmin(1);
            $manager->persist($contributor);
            $manager->flush();
            $this->addFlash('success','Votre compte est crée');
            $this->redirectToRoute('contributor_creation_confirmation');
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
}
