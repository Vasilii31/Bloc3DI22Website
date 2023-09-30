<?php

    class ModelObjects{

        public function hydrate(array $infos)
        {
            foreach($infos as $clef => $donnee)
            {
                // On récupère le nom du setter correspondant à l'attribut.
                $methode = 'set'.$clef;
                //echo $clef.$donnee."";
                // Si le setter correspondant existe.
                if(method_exists($this, $methode))
                {
                    // On appelle le setter.
                    $this->$methode($donnee);
                }
            }
        }

    }