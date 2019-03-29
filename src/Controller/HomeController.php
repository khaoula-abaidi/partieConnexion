<?php

namespace App\Controller;

use App\Entity\Document;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home_page")
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
}