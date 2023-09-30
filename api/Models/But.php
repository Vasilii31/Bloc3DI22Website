<?php

require_once("ModelObjects.php");

    class But extends ModelObjects
    {
        private $idBut = 0;
        private $nomButeur = "";
        private $prenomButeur = "";
        private $idButeur = 0;
        private $contreSonCamp = false;
        private $minute = 0;   

        public function SetidBut($id)
        {
            $this->idBut = $id;
        }

        public function SetnomButeur($nom)
        {
            $this->nomButeur = $nom;
        }

        public function SetprenomButeur($prenom)
        {
            $this->prenomButeur = $prenom;
        }

        public function SetidButeur($idbuteur)
        {
            $this->idButeur = $idbuteur;
        }

        public function SetcontreSonCamp($csc)
        {
            $this->contreSonCamp = ($csc = 0 ? false : true);
        }

        public function Setminute($minute)
        {
            $this->minute = $minute;
        }

        public function jsonSerialize()
        {
            
            $vars = get_object_vars($this);
            return $vars;
        }
    }