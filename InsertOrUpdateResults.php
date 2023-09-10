<?php

    require("connectDB.php");
    require("Crud.php");

    $db = connect();

    if(isset($_POST))
    {
        var_dump($_POST);
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
                        var_dump($res);
                    }
                    else
                    {
                        $res = Update_ResultatsMatch($db, $equipeGagnante, $scoreEquipeGagnante, $scoreEquipePerdante, $dureeMatch, $_POST['idFeuille'], $_GET['update']);
                        var_dump($res);
                    }
                    
                }
                else
                {
                    header("location: DisplayAndRedirect.php?result=KO");
                }

        }
    }