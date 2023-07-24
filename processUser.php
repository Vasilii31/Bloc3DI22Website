<?php
    require "utils.php";
    require "connectDB.php";

    $db = connect();

    init_php_session();

    //on vérifie si on doit authentifier ou creer un utilisateur
    if(isset($_POST))
    {
        switch($_POST["logOrSign"])
        {
            case "login":
                $res = Login($db, $_POST);
                //cas particulier de login successfull
                if($res == "OK")
                    header("location: /index.php");  
                break;
            case "signin":
                $res = SignIn($db, $_POST);
                break;
            default:
                $res = "KO";
                break;
        }
        //header("location: /DisplayAndRedirect.php?result=".$res);
    }
    else
    {
        $res = "KO";
        //header("location: /DisplayAndRedirect.php?result=".$res);
    }
        


    