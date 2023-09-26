<?php
    require "../Librairies/utils.php";
    require "../Librairies/connectDB.php";

    $db = connect();

    init_php_session();

    //on vérifie si on doit authentifier ou creer un utilisateur
    if(isset($_POST))
    {
        var_dump($_POST);
        if($_POST["logOrSign"] == "login")
        {
            $res = Login($db, $_POST);
            //cas particulier de login successfull
            if($res == "OK"){
                header("location: ../Views/index.php");
                return;
            }
            else 
            {
                header("location: ../Views/DisplayAndRedirect.php?result=".$res);
            } 
        }
        else
        {
            $res = SignIn($db, $_POST);
        }
        
        header("location: ../Views/DisplayAndRedirect.php?result=".$res);
    }
    else
    {
        $res = "KO";
        header("location: ../Views/DisplayAndRedirect.php?result=".$res);
    }

    //var_dump($res);
        


    