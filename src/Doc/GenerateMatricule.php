<?php

namespace App\Doc;
use App\Entity\Medecin;
use App\Repository\MedecinRepository;

class GenerateMatricule extends MedecinRepository
{
    private $matricule;
    
    public function __construct(MedecinRepository $medecinRepo)
    {
        $med=$medecinRepo->findOneBy([],['id'=>'desc']);
        if($med !=null)
        {
            $lastId=$med->getId();
            $this->matricule=sprintf("%'.05d\n",$lastId+1);
        }else
        {
            $this->matricule=sprintf("%'.05d\n",1);
        } 
    }
    
    public function matricule(Medecin $medecin)
    {
        $index="M";
        $servive=$medecin->getService()->getLibelle();

        $Word=(str_word_count($servive,1));

        if(count($Word) >=2)
        {
            foreach($Word as $key=> $mot)
            {
                $index.=strtoupper(substr($mot,0,1));
            }
        }else
        {
            $index.=strtoupper(substr($Word[0],0,2));
        }
        return $index."".$this->matricule;
    }
}