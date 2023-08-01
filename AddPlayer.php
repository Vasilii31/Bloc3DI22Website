<?php
require "connectDB.php";
require "Crud.php";
require "utils.php";

if(!init_php_session() || !is_logged())
{
    header("location: /auth.php");
    return;
}

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
        //TO DO verifier que l'idposte est correct
        $idPoste = intval($_POST["poste"]);
        //TO DO verifier l'identraineur pour valider l'insertion dans l'équipe 
        $equipe = intval($_POST["equipe"]);
        if($numMaillot > 0 && $numMaillot < 45 && $idPoste > 0 && $equipe > 0)
        {
            //insertion dans la BDD 
            $result = Add_Player($db, $nom, $prenom, $numMaillot, $idPoste, $equipe);
            if($result == "OK")
            {
                //on redirige vers la page de display de la team
                //header("location :");
                return;
            }
                
        }
    }
    var_dump("ERREUR AJOUT JOUEUR");
    //on redirige vers la page d'erreur
    //header("location: /DisplayAndRedirect.php");
}



?>