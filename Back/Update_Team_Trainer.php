<?php

    require "../Librairies/connectDB.php";
    require "../Librairies/Crud.php";
    require "../Librairies/utils.php";

    init_php_session();
    grant_access(true);

    $db = connect();

    if(isset($_POST) && count($_POST) > 0)
    {
        if(intval($_POST["Equipe"]) > 0)
        {
            if(intval($_POST["Trainer"]) > 0)
            {
                $res = Update_Team_Trainer($db, $_POST["Equipe"], $_POST["Trainer"]);
                if($res == "KO")
                {
                    header("location: ../Views/DisplayAndRedirect.php?result=KO");
                    return;
                }         
            }
            if(intval($_POST["TrainerAdjoint"]) > 0)
            {
                $res = Update_Team_TrainerAdjoint($db, $_POST["Equipe"], $_POST["TrainerAdjoint"]);
                if($res == "KO")
                {
                    header("location: ../Views/DisplayAndRedirect.php?result=KO");
                    return;
                }         
            }
            header("location: ../Views/AttributionEntraineur.php");
        }
        else
            header("location: ../Views/DisplayAndRedirect.php?result=KO");

    }
    else
        header("location: ../Views/DisplayAndRedirect.php?result=KO");


