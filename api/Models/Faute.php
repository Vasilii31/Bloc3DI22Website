<?php

require_once("ModelObjects.php");

    class Faute extends ModelObjects
    {
        private $idCarton = 0;
        private $joueurSanctionne = "";
        private $NomCarton = "";
        private $minute = 0;   

        public function SetidCarton($id)
        {
            $this->idCarton= $id;
        }

        public function SetjoueurSanctionne($joueur)
        {
            $this->joueurSanctionne = $joueur;
        }

        public function SetNomCarton($carton)
        {
            $this->NomCarton = $carton;
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