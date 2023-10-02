<?php

require_once("ModelObjects.php");

    class Changement extends ModelObjects
    {
        private $idChangement = 0;
        private $joueurEntrant = "";
        private $joueurSortant = "";
        private $minute = 0;   

        public function SetidRemplacement($id)
        {
            $this->idChangement= $id;
        }

        public function SetjoueurEntrant($joueur)
        {
            $this->joueurEntrant = $joueur;
        }

        public function SetjoueurSortant($joueur)
        {
            $this->joueurSortant = $joueur;
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