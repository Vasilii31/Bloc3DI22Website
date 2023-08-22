<?php
    require("connectDB.php");
    require("Crud.php");
    $db = connect();

    var_dump($_POST);
    
    if($_POST["DateRencontre"] != "" && $_POST["equipe1"] != "" && $_POST["equipe2"] != "" && $_POST["lieu"] != "" && $_POST["ArbitreP"] != "" && $_POST["ArbitreA1"] != "" && $_POST["ArbitreA2"] != "")
    {
        //A ajouter : date de création et admin créateur de la feuille
        $idfeuille = Add_New_Match_Sheet($db, $_POST["DateRencontre"], $_POST["Stade"], $_POST["Equipe1"], $_POST["Equipe2"], $_POST["ArbitrePrinc"], $_POST["ArbitreAss1"], $_POST["ArbitreAss2"]);
        if($idfeuille > 0)
        {   
            $res = Create_All_Sheets($db, $idfeuille,$_POST["Equipe1"], $_POST["Equipe2"]);
        }
        else 
            $res = "KO"; 
    }
    else{
        echo "Insufficient data.";
    }
    header("location: /DisplayAndRedirect.php?result=".$res);
    