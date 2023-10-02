<?php

    require_once("ModelObjects.php");

    class MatchObject extends ModelObjects{

        private $id = 0;
        private $dateRencontre = "";
        private $stade = "";
        private $duree = 0;
        private $equipe1;
        private $equipe2;
        private $arbitrePrincipal = [];
        private $arbitreAssistant1 = [];
        private $arbitreAssistant2 = [];
        private $scoreEquipeGagnante = 0;
        private $scoreEquipePerdante = 0;
        private $vainqueur = "";
        private $perdant = "";
        private $buts = [];
        private $changements = [];
        private $fautes = [];

        public function __construct($id, $dateRencontre, $stade,
            $duree, $equipe1Object, $equipe2Object, $arrayArbitres, 
            $scoreEquipeGagnante, $scoreEquipePerdante, $vainqueur,
            $perdant, $arrayButs, $arrayChangements, $arrayFautes)
        {
            $this->Setid($id);
            $this->SetdateRencontre($dateRencontre);
            $this->Setstade($stade);
            $this->Setduree($duree);
            $this->SetEquipe1($equipe1Object);
            $this->SetEquipe2($equipe2Object);
            $this->SetarbitrePrincipal($arrayArbitres);
            $this->SetarbitreAssistant1($arrayArbitres);
            $this->SetarbitreAssistant2($arrayArbitres);
            $this->SetscoreEquipeGagnante($scoreEquipeGagnante);
            $this->SetscoreEquipePerdante($scoreEquipePerdante);
            $this->Setvainqueur($vainqueur);
            $this->Setperdant($perdant);
            $this->Setbuts($arrayButs);
            $this->SetChangements($arrayChangements);
            $this->SetFautes($arrayFautes);

        }

        public function Setid($id)
        {
            $this->id = $id;
        }

        public function SetdateRencontre($date)
        {
            $this->dateRencontre = $date;
        }

        public function Setstade($stade)
        {
            $this->stade = $stade;
        }

        public function Setduree($duree)
        {
            $this->duree = $duree;
        }

        public function Setequipe1($equipe1Object)
        {
            $this->equipe1 = $equipe1Object->jsonSerialize();
        }

        public function Setequipe2($equipe2Object)
        {
            $this->equipe2 = $equipe2Object->jsonSerialize();
        }

        public function SetarbitrePrincipal($arrayArbitres)
        {
            $this->arbitrePrincipal = [$arrayArbitres["NomArbitrePrincipal"], $arrayArbitres["NationaliteArbitrePrincipal"]];
        }

        public function SetarbitreAssistant1($arrayArbitres)
        {
            $this->arbitreAssistant1 = [$arrayArbitres["NomArbitreAssistant1"], $arrayArbitres["NationaliteArbitreAssistant1"]];
        }

        public function SetarbitreAssistant2($arrayArbitres)
        {
            $this->arbitreAssistant2 = [$arrayArbitres["NomArbitreAssistant2"], $arrayArbitres["NationaliteArbitreAssistant2"]];
        }

        public function SetscoreEquipeGagnante($scoreEquipeGagnante)
        {
            $this->scoreEquipeGagnante = $scoreEquipeGagnante;
        }

        public function SetscoreEquipePerdante($scoreEquipePerdante)
        {
            $this->scoreEquipePerdante = $scoreEquipePerdante;
        }

        public function Setvainqueur($vainqueur)
        {
            $this->vainqueur = $vainqueur;
        }

        public function Setperdant($perdant)
        {
            $this->perdant = $perdant;
        }

        public function Setbuts($arrayButs)
        {
            if(count($arrayButs) > 0)
            {
                foreach($arrayButs as $but)
                {
                    $b = new But();
                    $b->hydrate($but);
                    //array_push($this->joueurs, $j);
                    array_push($this->buts, $b->jsonSerialize());
                }
            }
        }

        public function SetFautes($arrayFautes)
        {
            if(count($arrayFautes) > 0)
            {
                foreach($arrayFautes as $faute)
                {
                    $f = new Faute();
                    $f->hydrate($faute);
                    //array_push($this->joueurs, $j);
                    array_push($this->fautes, $f->jsonSerialize());
                }
            }
        }

        public function SetChangements($arrayChangements)
        {
            if(count($arrayChangements) > 0)
            {
                foreach($arrayChangements as $changement)
                {
                    $c = new Changement();
                    $c->hydrate($changement);
                    //array_push($this->joueurs, $j);
                    array_push($this->changements, $c->jsonSerialize());
                }
            }
        }

        public function jsonSerialize()
        {
            $vars = get_object_vars($this);
            return $vars;
        }
    }