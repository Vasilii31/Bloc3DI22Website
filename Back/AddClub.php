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

    if($_POST['id'] == "")
    {
        $res = InsertClub($db, $_POST["Nom"]);
    }
    else if(intval($_POST['id']) > 0)
    {
        $res = ModifyClub($db, $_POST['id'], $_POST["Nom"]);
    }

    if($res == "OK")
        header("location: ../Views/CreationClub.php");
    else
        header("location: ../Views/DisplayAndRedirect.php?result=KO");
}