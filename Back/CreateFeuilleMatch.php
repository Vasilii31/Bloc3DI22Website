<?php
    require("../Librairies/connectDB.php");
    require("../Librairies/Crud.php");
    require("../Librairies/utils.php");

    init_php_session();
    grant_access(true);

    $db = connect();

    var_dump($_POST);
    
    if($_POST["DateRencontre"] != "" && $_POST["Equipe1"] != "" && $_POST["Equipe2"] != "" && $_POST["Stade"] != "" && $_POST["ArbitrePrinc"] != "" && $_POST["ArbitreAss1"] != "" && $_POST["ArbitreAss2"] != "")
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
    header("location: ../Views/DisplayAndRedirect.php?result=".$res);
    