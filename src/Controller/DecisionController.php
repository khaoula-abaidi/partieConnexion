<?php

namespace App\Controller;

use App\Repository\DecisionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DecisionController extends AbstractController
{
    /**
     * @Route("/decisions", name="decision_index")
     */
    public function index(DecisionRepository $decisionRepository)
    {
        /**
         * Extraction of all décisions not taken yet
         */
        $decisions = $decisionRepository->findBy(['isTaken'=>false]);
        if(!$decisions){
            return $this->render('decision/error.html.twig');
        }
        return $this->render('decision/index.html.twig', [
            'controller_name' => 'DecisionController',
            'decisions' => $decisions
        ]);
    }
}
