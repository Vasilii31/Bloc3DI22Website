<?php

require("../Librairies/connectDB.php");
require("../Librairies/Crud.php");
require("../Librairies/utils.php");

init_php_session();
grant_access(false);

$db = connect();


if(isset($_GET['idFeuilleE']) && intval($_GET['idFeuilleE']) > 0
    && isset($_GET['idFeuilleM']) && intval($_GET['idFeuilleM']) > 0)
{
    var_dump($_POST);
    //feuille match ou feuille match entraineur ?
    $idListeJoueur = Create_Liste_JoueursMatch($db, $_GET['idFeuilleE']);
    if($idListeJoueur > 0)
    {
        for($i = 1; $i < 11; $i++)
        {
            $titulaire = true;
            if(Add_JoueurMatch($db, $_POST["idPlayer".$i], $_POST["postePlayer".$i] , $idListeJoueur, $titulaire) == "KO")
            {
                //un insert n'a pas marché, on traite l'erreur, 
                //on delete la liste et on arrête tout
                var_dump("ERREUR INSERT TITULAIRE");
            }
        }
        for($i = 1; $i < 6; $i++)
        {
            $titulaire = false;
            if(Add_JoueurMatch($db, $_POST["substitute".$i], null, $idListeJoueur, $titulaire) == "KO")
            {
                //un insert n'a pas marché, on traite l'erreur, 
                //on delete la liste et on arrête tout
                var_dump("ERREUR INSERT REMPLACANT");
            }
        }
    }
    else{
        //l'insert de la liste de joueurs n'a pas marché, on traite l'erreur
        //On informe et on redirige
        var_dump("ERREUR INSERT LISTE");
    }
    if(Update_FeuilleMatchEntraineur($db, $_GET['idFeuilleE'], $idListeJoueur, $_POST['capitaine'], $_POST['suppleant']) == false)
    {
        //l'update de la feuille de match n'a pas marché, on traite l'erreur
        //on delete la liste, on arrête tout et on redirige
        var_dump("ERREUR UPDATE FDME");
    }
    else
    {
        header("location: ../Views/DisplayAndRedirect.php?result=TRAINERSHEETOK");
    }
}