<?php

    require_once("./Models/JoueurMatch.php");
    require_once("./Models/EquipeMatch.php");
    require_once("./Models/MatchObject.php");
    require_once("./Models/But.php");
    require_once("./Models/Faute.php");
    require_once("./Models/Changement.php");
    require("../Librairies/connectDB.php");
    require("../Librairies/Crud.php");

    $db = connect();

    $joueur = new JoueurMatch();
    $res = Get_A_Player($db, 7);
    $joueur->hydrate($res);

    //var_dump($joueur);
    //echo json_encode($joueur->jsonSerialize(), JSON_UNESCAPED_UNICODE);

    $res = Get_Players($db, 1);
    $equipe = new EquipeMatch(1, "OM", "thierry", "Cedric", $res);

    //var_dump($equipe);
    //echo json_encode($equipe->jsonSerialize(), JSON_UNESCAPED_UNICODE);

    $arbitres = Get_match_arbitres($db, 7);
    $infosEquipes = Get_Infos_Equipes($db, 7);
    $equipe1 = Get_Players($db, 2);
    $e1 = new EquipeMatch(2, "OM", "thierry", "Cedric", $equipe1);
    $equipe2 = Get_Players($db, 1);
    $e2 = new EquipeMatch(1, "PSG", "Henry", "Thomas", $equipe2);
    $res = Get_All_Infos_Match_Appli($db, 7);
    $buts = Get_Match_Buts($db, 7);
    $fautes = Get_Match_Cartons($db, 7);
    $changements = Get_Match_Changements($db, 7);

    var_dump($changements);
    //echo json_encode($e1->jsonSerialize(), JSON_UNESCAPED_UNICODE);

    $match_termine = new MatchObject($res["IdFeuille"], $res["DateRencontre"], $res["Stade"], $res["duree"],
        $e1, $e2, $arbitres, $res["ScoreEquipeGagnante"], $res["ScoreEquipePerdante"], $res["vainqueur"], $res["perdant"], $buts, $changements, $fautes);

    var_dump($match_termine);
    echo json_encode($match_termine->jsonSerialize(), JSON_UNESCAPED_UNICODE);
    