<?php

require_once("ModelObjects.php");

class SeasonStats extends ModelObjects{

    private $id = 0;
    private $nomEquipe = "";
    private $saison = "";
    private $nbMatchsJoues = 0;
    private $nbMatchsGagnes = 0;
    private $nbMatchsPerdus = 0;
    private $tauxDeVictoires = 0.0;
    private $nbButsMarques = 0;
    private $nbButsEncaisses = 0;
    private $nbCartonsAttribues = 0;
    private $top5Buteurs = [];
    private $meilleurMatch = [];
    private $pireMatch = [];
    
    public function __construct($id, $nomEquipe, $saison, $nbMatchsJoues, $nbMatchsGagnes, $nbButsMarques,
                         $nbButsEncaisses, $nbCartonsAttribues, $top5Buteurs, $meilleurMatch, $pireMatch)
    {
        $this->Setid($id);
        $this->SetnomEquipe($nomEquipe);
        $this->Setsaison($saison);
        $this->SetnbMatchsJoues($nbMatchsJoues);
        $this->SetnbMatchsGagnes($nbMatchsGagnes);
        $this->SetnbMatchsPerdus($nbMatchsJoues, $nbMatchsGagnes);
        $this->SettauxDeVictoires($nbMatchsJoues, $nbMatchsGagnes);
        $this->SetnbButsMarques($nbButsMarques);
        $this->SetnbButsEncaisses($nbButsEncaisses);
        $this->SetnbCartonsAttribues($nbCartonsAttribues);
        $this->Settop5Buteurs($top5Buteurs);
        $this->SetmeilleurMatch($meilleurMatch);
        $this->SetpireMatch($pireMatch);
    }

    public function Setid($id)
    {
        $this->id = $id;
    }

    public function SetnomEquipe($nomEquipe)
    {
        $this->nomEquipe = $nomEquipe;
    }

    public function Setsaison($saison)
    {
        $this->saison = $saison;
    }

    public function SetnbMatchsJoues($nb)
    {
        $this->nbMatchsJoues = $nb;
    }

    public function SetnbMatchsGagnes($nb)
    {
        $this->nbMatchsGagnes = $nb;
    }

    public function SetnbMatchsPerdus($nbMatchsJoues, $nbMatchsGagnes)
    {
        $this->nbMatchsPerdus = $nbMatchsJoues - $nbMatchsGagnes;
    }

    public function SettauxDeVictoires($nbMatchsJoues, $nbMatchsGagnes)
    {
            $this->tauxDeVictoires = fdiv($nbMatchsGagnes , $nbMatchsJoues);
    }

    public function SetnbButsMarques($nb)
    {
        $this->nbButsMarques = $nb;
    }

    public function SetnbButsEncaisses($nb)
    {
        $this->nbButsEncaisses = $nb;
    }

    public function SetnbCartonsAttribues($nb)
    {
        $this->nbCartonsAttribues = $nb;
    }

    public function Settop5Buteurs($buteurs)
    {
        if(count($buteurs) > 0)
            $this->top5Buteurs = $buteurs;
    }

    public function SetmeilleurMatch($match)
    {
        if($match["IdFeuille"] != null)
            $this->meilleurMatch = $match;
    }

    public function SetpireMatch($match)
    {
        if($match["IdFeuille"] != null)
            $this->pireMatch = $match;
    }

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);
        return $vars;
    }
}