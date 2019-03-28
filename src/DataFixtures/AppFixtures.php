<?php

namespace App\DataFixtures;

use App\Entity\Contributor;
use App\Entity\Document;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    /**
     * List of Real Contributors Informations
     */
    private $civil = ['Mr','Mme','Mademoiselle'];
    private $firstname = ['Paskin','Fring','Nenad','Sun'];
    private $lastname = ['Norman','Andrias','Manojlovic','Huh'];
    private $complementName = ['N.Paksin','A.Fring','N.Manojlovic','Sun.H'];
    private $email = ['paskin.nikolas@doi.org','afring@city.ac.uk','nmanoj@ualg.pt','shuh@hallym.ac.kr'];
    private $login = ['log123','log456','log789',''];
    private $pwd = ['0000','1111','2222','3333'];
    /**
     * List of Real Documents Informations
     */
    private $doi = ['10.3352/jeehp.2013.10.3','10.2991/jnmp.2006.13.4.1','10.1109/5.771073','10.1016/S8756-3282(01)00704-9'];
    private $title = ['Revision of the instructions to authors to require a structured abstract, digital object identifier of each reference, and author’s voice recording may increase journal access',
        'G 2-Calogero-Moser Lax operators from reduction','Toward unique identifiers','Bone mineral density of competitive male mountain and road cyclists'];
    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    { $contributors = new ArrayCollection();
     // Insert 4  Contributors to the Table Contributor
        for($j=0;$j<4;$j++){
            $contributor = new Contributor();
            $contributor->setCivility('Mr')
                ->setFirstname($this->firstname[$j])
                ->setLastname($this->lastname[$j])
                ->setComplementName($this->complementName[$j])
                ->setEmail($this->email[$j])
                ->setLogin($this->login[$j])
                ->setPwd($this->pwd[$j])
                ->setPhoto('http://placekitten.com/200/300');

            $manager->persist($contributor);
            $contributors->add($contributor);
        }

         // Insert 3  Documents to the Table Document

        for ($i=0;$i<3;$i++){
            $document = new Document();
            $document->setDoi($this->doi[$i])
                ->setTitle($this->title[$i]);
            if($i==0){
                $document->addContributor($contributors->get(3));
            }
            if($i==1){
                $document->addContributor($contributors->get(1));
                $document->addContributor($contributors->get(2));
            }
            if($i==2){
                $document->addContributor($contributors->get(0));
            }
            $manager->persist($document);
        }
         // Saving All Transformations

        $manager->flush();
    }
}
