<?php
    require "utils.php";
    require "connectDB.php";

    $db = connect();

    init_php_session();

    //on vérifie si on doit authentifier ou creer un utilisateur
    if(isset($_POST))
    {
        if($_POST["logOrSign"] == "login")
        {
            $res = Login($db, $_POST);
            //cas particulier de login successfull
            if($res == "OK"){
                header("location: ./index.php");
                return;
            }
            else 
            {
                header("location: ./DisplayAndRedirect.php?result=".$res);
            } 
        }
        else
        {
            $res = SignIn($db, $_POST);
        }
        
        header("location: /DisplayAndRedirect.php?result=".$res);
    }
    else
    {
        $res = "KO";
        header("location: ./DisplayAndRedirect.php?result=".$res);
    }

    //var_dump($res);
        


    