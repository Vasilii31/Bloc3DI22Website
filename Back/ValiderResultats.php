<?php

    require "../Librairies/connectDB.php";
    require "../Librairies/Crud.php";
    require "../Librairies/utils.php";

    init_php_session();
    grant_access(true);

    $db = connect();

    if(isset($_POST))
    {
        //insert
        $res = Set_Resultats_complete($db, $_POST['IdMatch']);
        //header en fonction du resultat
        var_dump($res);
        if($res == true)
            header("location: ../Views/DisplayAndRedirect.php?result=MATCHCOMPLETE");
        else
            header("location: ../Views/DisplayAndRedirect.php?result=KO");
    }
    