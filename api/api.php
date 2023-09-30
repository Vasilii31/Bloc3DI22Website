<?php
    require_once("./Models/JoueurMatch.php");
    require_once("./Models/EquipeMatch.php");
    require_once("./Models/MatchObject.php");
    require_once("./Models/But.php");
    require_once("./Models/Faute.php");
    require_once("./Models/Changement.php");
    require("../Librairies/connectDB.php");
    require("../Librairies/Crud.php");
    require("../Librairies/utils.php");

    $db = connect();

    if(isset($_GET["f"]))
    {
        switch($_GET["f"])
        {
            case "infosMatch":
                if(intval($_GET["idmatch"] > 0))
                {
                    $res = CreateMatchObject($db, $_GET["idmatch"]);
                }
                break;

                         
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
    }


    function CreateMatchObject($db, $idmatch)
    {
        if(intval($idmatch) > 0)
        {
            $arbitres = Get_match_arbitres($db, $idmatch);
            $infosEquipes = Get_Infos_Equipes($db, $idmatch);
            $infosMatch = Get_All_Infos_Match_Appli($db, $idmatch);
            if($arbitres != false && count($arbitres) > 0 
                && $infosEquipes != false && count($infosEquipes) > 0 
                && $infosMatch != false && count($infosMatch) > 0)
            {
                $equipe1 = Get_Players($db, $infosEquipes['IdEquipe1']);
                $equipe2 = Get_Players($db, $infosEquipes['IdEquipe2']);
                if($equipe1 != false && count($equipe1) > 0 && $equipe2 != false && count($equipe2) > 0)
                {
                    $e1 = new EquipeMatch($infosEquipes['IdEquipe1'],  $infosEquipes['NomEquipe1'],  $infosEquipes['entraineurEquipe1'], $infosEquipes['entraineurAdjointEquipe1'], $equipe1);
                    $e2 = new EquipeMatch($infosEquipes['IdEquipe2'],  $infosEquipes['NomEquipe2'],  $infosEquipes['entraineurEquipe2'], $infosEquipes['entraineurAdjointEquipe2'], $equipe2);
                    $buts = Get_Match_Buts($db, 7);
                    $fautes = Get_Match_Cartons($db, 7);
                    $changements = Get_Match_Changements($db, 7);
                    if($buts != false && $fautes != false && $changements  != false)
                    {
                        $match_termine = new MatchObject($infosMatch["IdFeuille"], $infosMatch["DateRencontre"], $infosMatch["Stade"], $infosMatch["duree"],
                            $e1, $e2, $arbitres, $infosMatch["ScoreEquipeGagnante"], $infosMatch["ScoreEquipePerdante"], $infosMatch["vainqueur"], $infosMatch["perdant"], $buts, $changements, $fautes);
                        if($match_termine != null)
                        {
                            http_response_code(200);
                            return $match_termine->jsonSerialize();
                        }
                    }
                }
            }
            
        }
        http_response_code(404);
        return "Not Found";
    }