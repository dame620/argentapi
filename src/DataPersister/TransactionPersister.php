<?php
namespace App\DataPersister;
use App\Entity\Transaction;
use App\Repository\ContratRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;


class TransactionPersister implements DataPersisterInterface
{

    private $entityManager;
    private $repocont;
    public function __construct(EntityManagerInterface $entityManager,ContratRepository $repocont)
    {
        
        $this->entityManager = $entityManager;
        $this->repocont =  $repocont;
    }

    public function supports($data): bool
    {
        
        return $data instanceof Transaction;
       
    }

    /**
     * @param Transaction $data
     */
    public function persist($data)

      {
     
       //$term = $this->repocont->findBy(['id'=>1]);
    
       $term=$this->repocont->find(2);
    
        $texterme=$term->getTerme();

$cod=$data->getCode();
//$nomretrait=getNomdestinataire();
$nomenvoyeu=$data->getNomemmeteur();
$cnienvoyeu=$data->getCniemetteur();
$nomuserpartenvoyeur=$data->getUserenvoi()->getNomcomplet();
$idpart=$data->getUserenvoi()->getPartenaire()->getId();

$nomrecept=$data->getNomdestinataire();
$telrecept=$data->getTeldestinataire();
$telenvoyeur=$data->getTelemetteur();
$sommeenvoiplusfrai=$data->getMontanttransaction();
$fraiseul=$data->getFrais();
$sommeenvoisansfrai=$sommeenvoiplusfrai-$fraiseul;

        $search=["prenomenvoyeur","cnienvoyeur","#codenv","nomcaissier","#prenomrecepteu","sommeenvoi",
        "fraitran","montanttot","telenvoyeur","telrecepteur","idpartenaire"];
        $replace=[$nomenvoyeu,$cnienvoyeu,$cod,$nomuserpartenvoyeur,$nomrecept,$sommeenvoisansfrai,
        $fraiseul,$sommeenvoiplusfrai,$telenvoyeur,$telrecept,$idpart];

        $newtexterme=str_replace ($search ,$replace , $texterme );
       // dd($newtexterme);
        $this->entityManager->persist($data);
        $this->entityManager->flush();

       //dd($newtexterme);
       // return new JsonResponse($newtexterme);
       }

    public function remove($data)
    {
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }



    }
