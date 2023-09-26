<?php

    require("../Librairies/connectDB.php");
    require("../Librairies/Crud.php");
    require("../Librairies/utils.php");

    init_php_session();
    grant_access(true);

    $db = connect();

    if(isset($_POST))
    {
        if(isset($_GET['update']))
        {
            
                $equipeGagnante = intval($_POST['EquipeGagnante']);
                $scoreEquipeGagnante = intval($_POST['scoreEquipeGagnante']);
                $scoreEquipePerdante = intval($_POST['scoreEquipePerdante']);
                $dureeMatch = intval($_POST['DureeMatch']);

                if($equipeGagnante > 0 && $scoreEquipeGagnante >= 0 && $scoreEquipePerdante >= 0 && $dureeMatch > 0
                    && isset($_POST['idFeuille']) && intval($_POST['idFeuille']) > 0)
                {
                    //si update est false, alors la feuille de résultat n'est pas encore crée
                    //il faut donc faire un insert
                    if($_GET['update'] == "0")
                    {
                        $res = Insert_ResultatsMatch($db, $equipeGagnante, $scoreEquipeGagnante, $scoreEquipePerdante, $dureeMatch, $_POST['idFeuille']);
                    }
                    else
                    {
                        $res = Update_ResultatsMatch($db, $equipeGagnante, $scoreEquipeGagnante, $scoreEquipePerdante, $dureeMatch, $_POST['idFeuille'], $_GET['update']);
                    }

                    if($res = "OK")
                    {
                        header("location: ../Views/ResultatsMatch.php?idFeuille=".$_POST['idFeuille']);
                    }
                    else{
                        header("location: ../Views/DisplayAndRedirect?result=KO");
                    }
                    
                }
                else
                {
                    header("location: ../Views/DisplayAndRedirect.php?result=KO");
                }

        }
    }