<?php 

    require_once("ModelObjects.php");

    class JoueurMatch extends ModelObjects{

        private $IdJoueur = 0;
        private $Nom = "";
        private $Prenom = "";
        private $NumeroMaillot = 0;
        private $NomPoste = "";

        public function SetIdJoueur($id)
        {
            $this->IdJoueur = $id;
        }

        public function SetNom($nom)
        {
            $this->Nom = $nom;
        }

        public function SetPrenom($prenom)
        {
            $this->Prenom = $prenom;
        }

        public function SetNumeroMaillot($num)
        {
            $this->NumeroMaillot = $num;
        }

        public function SetNomPoste($poste)
        {
            $this->NomPoste = $poste;
        }

        public function jsonSerialize()
        {
            $vars = get_object_vars($this);
            return $vars;
        }
    }