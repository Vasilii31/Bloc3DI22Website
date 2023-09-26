<?php

require "../Librairies/connectDB.php";
require "../Librairies/Crud.php";
require "../Librairies/utils.php";

init_php_session();
grant_access(true);

$db = connect();

if(isset($_POST) && count($_POST) > 0)
{
    
    var_dump($_POST);

    if(isset($_POST) && $_POST['Nom'] != "" && intval($_POST['Club'] > 0))
    {
        $res = InsertEquipe($db, $_POST["Club"], $_POST["Nom"]);
        if($res == "OK")
            header("location: ../Views/CreationEquipe.php");
         else
            header("location: ../Views/DisplayAndRedirect.php?result=KO");
    }
    else
        header("location: ../Views/DisplayAndRedirect.php?result=KO");

    
}