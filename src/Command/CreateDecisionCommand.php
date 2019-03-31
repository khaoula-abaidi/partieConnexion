<?php

namespace App\Command;

use App\Entity\Decision;
use App\Repository\ContributorRepository;
use App\Repository\DocumentRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;

class CreateDecisionCommand extends Command
{
    protected static $defaultName = 'decision:create';
    private $documentRepository;
    private $contributorRepository;
    public function __construct(ContributorRepository $contributorRepository,DocumentRepository $documentRepository, ObjectManager $objectManager)
    {
        parent::__construct();
        $this->objectManager = $objectManager;
        $this->contributorRepository = $contributorRepository ;
        $this->documentRepository = $documentRepository;
    }
    protected function configure()
    {
        $this
            ->setDescription('Create a deposit decision for a document related to a contributor not yet into HAL ')
            ->addArgument('admin',
                InputArgument::OPTIONAL,
                'Administrator multiple decisions')
            ->addOption('document',
                'd',
                InputOption::VALUE_REQUIRED,
                'The identifiant of the document concerned about the deposit')
            ->addOption('contributor',
                'c',
                InputOption::VALUE_REQUIRED,
                'The identifiant of the contributor concerned about the deposit')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $admin = $input->getArgument('admin');
        $docID = $input->getOption('document');
        $conID = $input->getOption('contributor');
        if ($admin) {
            $io->note(sprintf('You passed an argument: %s', $admin));
        }
        else{
            /**
            *    Getting The document's informations using the id given in option d
            */
                $doc = $this->documentRepository->find($docID);
            /**
            *   Guetting The contributor's informations using the id given in option c
         */
                $con = $this->contributorRepository->find($conID);
          /**
           *   Asking for decision [ Dépôt dans HAL ? , Non , Ultérieurement ]
           */
                $helper = $this->getHelper('question');
                $question = new ChoiceQuestion(
                                                'Voulez-vous déposer ce document dans HAL ? ',
                                                ['Oui', 'Non', 'Ultérieurement'],
                                                0
                                            );
                $question->setErrorMessage('Votre choix  %s est invalide');

                $reponse = $helper->ask($input, $output, $question);
            /**
             * Insert the decision into the database for treatment
             */
                $decision = new Decision();
                $decision->setDocument($doc)
                    ->setContributor($con)
                    ->setContent($reponse)
                    ->setAllowedAt(new \DateTime());
                switch($reponse){
                    case 'Oui': $decision->setIsTaken(true);break;
                    case 'Non' : $decision->setIsTaken(false);break;
                    case 'Ultérieurement': $decision->setIsTaken(false);break;
                }
                $this->objectManager->persist($decision);
                $this->objectManager->flush();
                $output->writeln('Vous venez de répondre par : '.$reponse);
            }
        $io->success('Félicitations : Votre décision est prise  && Veuillez attendre quelques secondes pour son traitement .');
    }
}
