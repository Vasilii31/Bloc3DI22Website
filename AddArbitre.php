<?php

require "connectDB.php";
require "Crud.php";
require "utils.php";

// if(!init_php_session() || !is_logged() || !isAdmin())
// {
//     header("location: /auth.php");
//     return;
// }

$db = connect();

if(isset($_POST) && count($_POST) > 0)
{
    
    var_dump($_POST);

    if($_POST['id'] == "")
    {
        $res = InsertArbitre($db, $_POST["Nom"], $_POST["Nationalite"]);
    }
    else if(intval($_POST['id']) > 0)
    {
        $res = ModifyArbitre($db, $_POST['id'], $_POST["Nom"], $_POST["Nationalite"]);
    }

    if($res == "OK")
        header("location: Arbitre.php");
    else
        header("location: DisplayAndRedirect.php?result=KO");
}
else{
    if(intval($_GET['id']) > 0 && $_GET['delete'] == "true")
    {
        $res = DeleteArbitre($db, $_GET['id']);
        
        if($res == "OK")
            header("location: Arbitre.php");
        else
            header("location: DisplayAndRedirect.php?result=KO");
    }

}