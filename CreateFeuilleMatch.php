<?php
    require("connectDB.php");
    require("Crud.php");
    $db = connect();

    var_dump($_POST);
    header("location: /index.php");
    if($_POST["DateRencontre"] != "" && $_POST["equipe1"] != "" && $_POST["equipe2"] != "" && $_POST["lieu"] != "" && $_POST["ArbitreP"] != "" && $_POST["ArbitreA1"] != "" && $_POST["ArbitreA2"] != "")
    {
        AddFeuilleMatch($db, $_POST["DateRencontre"], $_POST["Stade"], $_POST["equipe1"], $_POST["equipe2"], $_POST["ArbitreP"], $_POST["ArbitreA1"], $_POST["ArbitreA2"]);
    }
    else{
        echo "Insufficient data.";
    }
    