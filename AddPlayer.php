<?php
require "connectDB.php";
require "Crud.php";
require "utils.php";

// if(!init_php_session() || !is_logged())
// {
//     header("location: /auth.php");
//     return;
// }

$db = connect();


if(isset($_POST))
{
    //verifier l'identraineur pour valider l'insertion dans l'équipe ?
    $result = "KO";
    if(is_string($_POST["nom"]) && $_POST["nom"] != "" &&
         is_string($_POST["prenom"]) && $_POST["prenom"] != "" &&
         is_string($_POST["num"]) && $_POST["num"] != "" &&
         is_string($_POST["equipe"]) && $_POST["equipe"] != "" &&
         is_string($_POST["poste"]) && $_POST["poste"] != "")
    {
        $nom = trim($_POST["nom"], "<;>");
        $prenom = trim($_POST["prenom"], "<;>");
        $numMaillot = intval($_POST["num"]);
        $idPoste = intval($_POST["poste"]);    
        $equipe = intval($_POST["equipe"]);
        //A VERIFIER EN PAGE D'ACCES ?
        //on vérifie que l'entraineur a les droits pour l'insertion dans l'équipe
        // if(!verif_Access_TrainerToTeam($db, $equipe, $_SESSION["username"]))
        // {
        //     header("location: /DisplayAndRedirect.php?result=KO");
        //     return;
        // }
        //on verifie que le numero de maillot est bien un Int entre 1 et 44
        //et que l'idPoste est bien un Int entre 1 et 10 (10 postes en base de donnée)
        if($numMaillot > 0 && $numMaillot < 45 && $idPoste > 0 && $idPoste < 11 && $equipe > 0)
        {
            //insertion dans la BDD 
            $result = Create_Player($db, $nom, $prenom, $numMaillot, $idPoste, $equipe);
            if($result == "OK")
            {
                //on redirige vers la page de display de la team
                //header("location :");
                var_dump("result de addPlayer : ");
                var_dump($result);
                return;
            }
                
        }
    }
    var_dump("ERREUR AJOUT JOUEUR");
    //on redirige vers la page d'erreur
    header("location: /DisplayAndRedirect.php?result=KO");
}



?>