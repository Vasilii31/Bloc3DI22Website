<?php

    require_once("ModelObjects.php");

class EquipeMatch extends ModelObjects{

    private $id;
    private $nom = "";
    private $nomEntraineur = "";
    private $nomEntraineurAdjoint = "";
    //private $joueurs = [];
    private $joueurs = [];

    public function __construct($id ,$nom, $nomEntraineur, $nomEntraineurAdjoint, $arrayJoueurs)
    {
        $this->Setid($id);
        $this->SetNom($nom);
        $this->SetnomEntraineur($nomEntraineur);
        $this->SetnomEntraineurAdjoint($nomEntraineurAdjoint);
        $this->Setjoueurs($arrayJoueurs);
    }

    public function Setid($id)
    {
        $this->id = $id;
    }

    public function SetNom($nom)
    {
        $this->nom = $nom;
    }

    public function SetnomEntraineur($nomEntraineur)
    {
        $this->nomEntraineur = $nomEntraineur;
    }

    public function SetnomEntraineurAdjoint($nomEntraineurAdjoint)
    {
        $this->nomEntraineurAdjoint = $nomEntraineurAdjoint;
    }

    public function Setjoueurs($arrayJoueurs)
    {
        if(count($arrayJoueurs) > 0)
        {
            foreach($arrayJoueurs as $joueur)
            {
                $j = new JoueurMatch();
                $j->hydrate($joueur);
                //array_push($this->joueurs, $j);
                array_push($this->joueurs, $j->jsonSerialize());
            }
        }
        
    }

    public function jsonSerialize()
    {
        
        $vars = get_object_vars($this);
        return $vars;
    }

}

