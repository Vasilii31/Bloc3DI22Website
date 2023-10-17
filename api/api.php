<?php
    require_once("./Models/JoueurMatch.php");
    require_once("./Models/EquipeMatch.php");
    require_once("./Models/MatchObject.php");
    require_once("./Models/But.php");
    require_once("./Models/Faute.php");
    require_once("./Models/Changement.php");
    require_once("./Models/SeasonStats.php");
    require("../Librairies/connectDB.php");
    require("../Librairies/Crud.php");
    require("../Librairies/utils.php");

    $db = connect();

    if(isset($_GET["f"]))
    {
        switch($_GET["f"])
        {
            case "equipes":
                $res = createEquipes($db);
                break;
            case "matchs":
                $res = createMatchs($db);
                break;
            case "infosMatch":
                if(isset($_GET["idmatch"]) && intval($_GET["idmatch"] > 0))
                {
                    $res = CreateMatchObject($db, $_GET["idmatch"]);
                }
                break;
            case "statsEquipe":
                if(isset($_GET["idequipe"]) && intval($_GET["idequipe"]) > 0 
                    && isset($_GET["season"]) && intval($_GET["season"]) > 0)
                {
                    $res = CreateStatsEquipe($db, $_GET["idequipe"], $_GET["season"]);
                }
                break;

                         
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
    }

    function createMatchs($db)
    {
        $res = Get_All_Matches_infos($db);
        return $res;
    }

    function createEquipes($db)
    {
        $res = Get_teams($db);
        return $res;
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

    function CreateStatsEquipe($db, $idequipe, $season)
    {
        $team = Get_team($db, $idequipe);
        if($team != false)
        {
            
            $winrate = Get_Team_MatchesStats($db, $idequipe, $season);
            if(intval($winrate["MatchesPlayed"]) != 0)
            {
            
                $butsMarques = Get_Team_Buts_Marques_Stats($db, $idequipe, $season);
                $butsEncaisses = Get_Team_Buts_Encaisses_Stats($db, $idequipe, $season);
                $cartonsAttribues = Get_Team_CartonsStats($db, $idequipe, $season);
                $meilleursButeurs = Get_Best_Team_Buteurs($db, $idequipe, $season);
                $meilleurMatch = Get_Best_Team_MatchSaison($db, $idequipe, $season);
                $pireMatch = Get_Worst_Team_MatchSaison($db, $idequipe, $season);
                $statsEquipeSaison = new SeasonStats($idequipe, $team["NomEquipe"], $season, $winrate["MatchesPlayed"], $winrate["MatchesWon"], $butsMarques["nombreDeButsMarques"],
                                            $butsEncaisses["nombreDeButsEncaisses"], $cartonsAttribues["nombreDeCartons"], $meilleursButeurs, $meilleurMatch, $pireMatch);

                http_response_code(200);
                return $statsEquipeSaison->jsonSerialize();
            }
            else
            {
                http_response_code(404);
                return "not found";
            }
        }
        else
        {
            http_response_code(404);
            return "not found";
        }   
    }