<?php

namespace App\Controller;

use App\Entity\Document;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DocumentController extends AbstractController
{
    /**
     * @Route("/documents/show/{id}", name="documents_show")
     */
    public function show($id)
    {
        $document = $this-> getDoctrine()
                          -> getRepository(Document::class)
                          -> find($id);
        if (!$document) {

            return $this->render('document/error.html.twig');

        }
        return $this->render('document/index.html.twig', [
            'controller_name' => 'DocumentController',
            'document' => $document
        ]);
    }
}
