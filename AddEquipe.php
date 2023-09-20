<?php

require "connectDB.php";
require "Crud.php";
require "utils.php";

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
            header("location: CreationEquipe.php");
         else
            header("location: DisplayAndRedirect.php?result=KO");
    }
    else
        header("location: DisplayAndRedirect.php?result=KO");

    
}