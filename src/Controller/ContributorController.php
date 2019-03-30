<?php

namespace App\Controller;

use App\Entity\Contributor;
use App\Repository\ContributorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContributorController extends AbstractController
{
    /**
     * @Route("/contributor/create", name ="contributor_create")
     * @return Response
     */
    public function create() : Response
    {

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
