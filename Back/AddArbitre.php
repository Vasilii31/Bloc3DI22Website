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
        $res = InsertArbitre($db, $_POST["Nom"], $_POST["Nationalite"]);
    }
    else if(intval($_POST['id']) > 0)
    {
        $res = ModifyArbitre($db, $_POST['id'], $_POST["Nom"], $_POST["Nationalite"]);
    }

    if($res == "OK")
        header("location: ../Views/Arbitre.php");
    else
        header("location: ../ViewsDisplayAndRedirect.php?result=KO");
}
else{
    if(intval($_GET['id']) > 0 && $_GET['delete'] == "true")
    {
        $res = DeleteArbitre($db, $_GET['id']);
        
        if($res == "OK")
            header("location: ../Views/Arbitre.php");
        else
            header("location: ../Views/DisplayAndRedirect.php?result=KO");
    }

}