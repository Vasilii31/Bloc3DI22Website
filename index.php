<?php
    require("connectDB.php");
    //require("Crud.php");
    require("utils.php");

    init_php_session();

    if(!is_logged())
    {
        header("location: /auth.php");
    }
    $db = connect();

    $matchs = Get_Pending_Matchs($db);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Mes Matchs en cours :</h1>
    <?php
        if(count($matchs) > 0)
        {
            var_dump($matchs);
            echo $matchs[0]["NomEquipe1"];
            echo $matchs[0]["NomEquipe2"];
        }
    ?>
</body>
</html>