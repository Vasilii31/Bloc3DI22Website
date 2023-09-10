<?php

    function Get_Clubs($db)
    {
        $sReq = "SELECT * FROM clubs";
        $res = $db->query($sReq)->fetchAll();
        return $res;
    };

    function Get_Referees($db)
    {
        $sReq = "SELECT * FROM arbitres";
        $res = $db->query($sReq)->fetchAll();
        return $res;
    };

    // function Add_New_Match_Sheet($db, $date, $lieu, $equi1, $equi2, $arbitreP, $arbitreAss1, $arbitreAss2)
    // {
    //     $sReq = "INSERT INTO feuilledematch (DateRencontre, Lieu, IdEquipe1, IdEquipe2, IdArbitrePrinc, IdArbitreAss1, IdArbitreAss2) VALUES (?, ?, ?, ?, ?, ?, ?)";
    //     $dbh = $db->prepare($sReq);
    //     $dbh->execute([
    //         $date,
    //         $lieu,
    //         $equi1,
    //         $equi2,
    //         $arbitreP,
    //         $arbitreAss1,
    //         $arbitreAss2
    //     ]);
    // }

    //Doublon, a tester
    function Add_New_Match_Sheet($db, $DateRencontre, $Stade, $Equipe1, $Equipe2, $ArbitrePrinc, $ArbitreAss1, $ArbitreAss2)
    {
    
        $req = "INSERT INTO feuilledematch (DateRencontre, Stade, IdEquipe1, IdEquipe2, IdArbitrePrinc, IdArbitreAss1, IdArbitreAss2) VALUES (:DateRencontre, :Stade, :Equipe1, :Equipe2, :ArbitrePrinc, :ArbitreAss1, :ArbitreAss2)";
    
        $insertFeuilleDeMatch = $db -> prepare($req);
        if($insertFeuilleDeMatch -> execute(array(
            ':DateRencontre' => $DateRencontre,
            ':Stade' => $Stade,
            ':Equipe1' => $Equipe1,
            ':Equipe2' => $Equipe2,
            ':ArbitrePrinc' => $ArbitrePrinc,
            ':ArbitreAss1' => $ArbitreAss1,
            ':ArbitreAss2' => $ArbitreAss2
        )) == false)
        {
            $id = -1;
        }
        else
        {
            $id = $db->lastInsertId();
        } 
        return($id);
    }

function Get_Pending_Matchs($db)
{
    $sReq = "SELECT c1.NomClub as NomEquipe1, c2.NomClub as NomEquipe2, DateRencontre, Stade FROM feuilledematch AS f INNER JOIN clubs AS c1 ON f.IdEquipe1 = c1.IdClub INNER JOIN clubs as c2 on f.IdEquipe2 = c2.IdClub INNER JOIN arbitres as a1 on f.IdArbitrePrinc = a1.IdArbitre INNER JOIN arbitres as a2 on f.IdArbitreAss1 = a2.IdArbitre INNER JOIN arbitres as a3 on f.IdArbitreAss2 = a3.IdArbitre";
    $res = $db->query($sReq)->fetchAll();
    return $res;

}

function Create_User($db, $nom, $prenom, $id, $mail, $tel, $hmdp, $isAdmin)
{
    //on cherche avant tout dans la table users si le username n'est pas deja pris
    $approuved = $isAdmin ? true : false;
    $sReq = $db->prepare("SELECT userName FROM users WHERE userName = ?");
    $sReq->execute([$id]);
    $res = $sReq->fetch();
    //si on a pas de résultat, le username n'est pas pris
    //on peut créer l'utilisateur
    if($res == false)
    {
        $sReq = "INSERT INTO users (userName, hmdp, isAdmin, approved, mail, nom, prenom, numtel) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $dbh = $db->prepare($sReq);
            if($dbh->execute([
                $id,
                $hmdp,
                $isAdmin,
                $approuved,
                $mail,
                $nom,
                $prenom,
                $tel
            ]) == false)
            {
                //l'insert n'a pas marché, on traite l'erreur
                return "KO";
            }
            else//on renvoie un code succes
                return "OK";
    }
    else
    {
        //ce nom d'utilisateur est déja pris, on renvoie un code d'erreur
        //pour avertir l'utilisateur
        return "USEDNAME";
    }
}

function Get_User($db, $username, $isAdmin)
{
    $sUsername = filter_var($username, FILTER_SANITIZE_STRING);
    if($sUsername == false)
    {
        return null;
    }
    else
    {
        $dbh = $db->prepare("SELECT userName, hMdp, IdUser, approved FROM users WHERE userName = ? AND isAdmin = ?");
        $dbh->execute([$username, $isAdmin]);
    }
    return $dbh->fetch();
}

function VerifyAdminCreation($db, $codeAdmin)
{
    //va chercher le code admin en base de données et compare avec l'input
    //retourne true si le code est bon
    //false si code KO
    $codeAdmin = intval($codeAdmin);
    if($codeAdmin > 0)
    {
        $dbh = $db->prepare("SELECT CodeAdmin FROM codeadmin");
        $dbh->execute();
        $res = $dbh->fetch();
        return(password_verify($codeAdmin, $res["CodeAdmin"]));
    }
    return(false);
}

function Get_Match_infos($db, $idFeuille)
{
    $idFeuille = intval($idFeuille);
    if($idFeuille > 0)
    {
        $dbh = $db->prepare("SELECT DateRencontre, Stade, c1.NomClub as Equipe1, c2.NomClub as Equipe2, c1.IdClub as IdEquipe1, c2.IdClub as IdEquipe2  FROM feuilledematch AS f INNER JOIN clubs AS c1 ON f.IdEquipe1 = c1.IdClub INNER JOIN clubs as c2 on f.IdEquipe2 = c2.IdClub WHERE IdFeuille = ?");
        $dbh->execute([$idFeuille]);
    }
    return $dbh->fetch();
}

function Get_All_Matches_infos($db)
{
        $dbh = $db->prepare("SELECT DateRencontre, Stade, c1.NomClub as Equipe1, c2.NomClub as Equipe2, rm.ScoreEquipeGagnante, rm.ScoreEquipePerdante  FROM feuilledematch AS f INNER JOIN clubs AS c1 ON f.IdEquipe1 = c1.IdClub INNER JOIN clubs AS c2 on f.IdEquipe2 = c2.IdClub INNER JOIN resultatmatch AS rm ON f.IdFeuille = Idfeuilledematch WHERE complete = 1");
        $dbh->execute();

    return $dbh->fetchAll();
}

//Récupère les données pour la page detailsMatch

function Get_All_Infos($db)
{
        $dbh = $db->prepare("SELECT DateRencontre, Stade, c1.NomClub as Equipe1, c2.NomClub as Equipe2, rm.ScoreEquipeGagnante, rm.ScoreEquipePerdante  FROM feuilledematch AS f INNER JOIN clubs AS c1 ON f.IdEquipe1 = c1.IdClub INNER JOIN clubs AS c2 on f.IdEquipe2 = c2.IdClub INNER JOIN resultatmatch AS rm ON f.IdFeuille = Idfeuilledematch WHERE complete = 1");
        $dbh->execute();

    return $dbh->fetchAll();
}


function Get_All_Postes($db)
{
    $sReq = "SELECT * FROM postes";
    $res = $db->query($sReq)->fetchAll();
    return $res;
}

//recupère la team liée à l'idEquipe dans la bdd: table equipes
function Get_team($db, $idequipe)
{
    $newId = intval($idequipe);
    if(is_int($newId) && $newId > 0)
    {
        $dbh = $db->prepare("SELECT IdEquipe, NomEquipe FROM equipes WHERE IdEquipe = ?");
        $dbh->execute([$newId]);
        $res = $dbh->fetch();
    }
    return $res;
}

//Ajoute un joueur dans la BDD:  table joueurs
function Create_Player($db, $nom, $prenom, $numMaillot, $idPoste, $equipe)
{
    $sReq = "INSERT INTO joueurs (Nom, Prenom, NumeroMaillot, IdEquipe, IdPostePredilection) VALUES (?, ?, ?, ?, ?)";
    $dbh = $db->prepare($sReq);
    if($dbh->execute([
        $nom,
        $prenom,
        $numMaillot,
        $equipe,
        $idPoste
    ]) == false)
    {
        //l'insert n'a pas marché, on traite l'erreur
        return "KO";
    }
    else
        return "OK"; 
}

function Create_All_Sheets($db, $idFeuille, $idEquipe1, $idEquipe2)
{
    $res = "MATCHCREATED";
    $sReq = "INSERT INTO feuillematchentraineur (Idfeuilledematch, IdEquipe) VALUES (?, ?)";
    $dbh = $db->prepare($sReq);
    if($dbh->execute([
        $idFeuille,
        $idEquipe1
    ]) == false)
    {
        //l'insert n'a pas marché, on traite l'erreur
        $res = "KO";
    }
    $sReq = "INSERT INTO feuillematchentraineur (Idfeuilledematch, IdEquipe) VALUES (?, ?)";
    $dbh = $db->prepare($sReq);
    if($dbh->execute([
        $idFeuille,
        $idEquipe2
    ]) == false)
    {
        //l'insert n'a pas marché, on traite l'erreur
        $res = "KO";
    }
    return $res;
}

function Get_pending_trainers($db)
{

    $dbh = $db->prepare("SELECT * FROM users WHERE isAdmin = false AND approved = 0 LIMIT 5");
    $dbh->execute();
    return $dbh->fetchAll();
}

function Get_denied_trainers($db)
{

    $dbh = $db->prepare("SELECT * FROM users WHERE isAdmin = false AND approved = -1");
    $dbh->execute();
    return $dbh->fetchAll();
}



function Get_My_Players($db, $myTeam)
{
    $dbh = $db->prepare("SELECT * FROM `joueurs` JOIN postes ON joueurs.IdPostePredilection = postes.IdPoste WHERE idEquipe = ?");
    $dbh->execute([$myTeam]);
    $res = $dbh->fetchAll();
    return $res;
}



function Get_Trainer_ID($db, $boolAdmin, $IdUser){
        
    $res = "";
    if($boolAdmin == false) {
        $dbh = $db->prepare("SELECT IdEntraineur FROM entraineurs WHERE IdUser = ? ");
        $res = $dbh->execute([$IdUser]);
        if($res == false) {
            $res = "";
        }
    } 
    return $res;
}

//Get Id Team from an Id Trainer//
function Get_IdTeam_FromTrainer($db, $idEntraineur){
    $dbh = $db->prepare("SELECT IdEquipe FROM `equipes` WHERE IdEntraineur = ?");
    $res = $dbh->execute([$idEntraineur]);
    return $res;
}

function Accept_Or_Decline_User($db, $iduser, $approved)
{
    $approvedNbr = ($approved == "true" ? 1 : -1);
    
    $sReq = "UPDATE users SET approved = ? WHERE IdUser = ?";
    $dbh = $db->prepare($sReq);
    $dbh->execute([
        $approvedNbr,
        $iduser
    ]);
    $sReq = "INSERT INTO entraineurs (IdUser) VALUES (?)";
    $dbh = $db->prepare($sReq);
    $dbh->execute([
        $iduser
    ]);
    
}

/*function Get_Matches_To_Complete($db, $idEntraineur)
{
    $sReq =" SELECT fdm.DateRencontre, fdm.Lieu, e.NomEquipe as monEquipe, ea.NomEquipe as equipeAdverse 
            from feuilledematch as fdm 
            INNER JOIN equipes as e on fdm.IdEquipe1 = e.IdEquipe 
            INNER JOIN equipes as ea on ea.IdEquipe = fdm.IdEquipe2 
            where (e.IdEntraineur = ? or e.IdEntraineurAdjoint = ?) AND fdm.complete = 0
            UNION
            SELECT fdm.DateRencontre, fdm.Lieu, e.NomEquipe as monEquipe, ea.NomEquipe as equipeAdverse 
            from feuilledematch as fdm 
            INNER JOIN equipes as e on fdm.IdEquipe2 = e.IdEquipe 
            INNER JOIN equipes as ea on ea.IdEquipe = fdm.IdEquipe1 
            where (e.IdEntraineur = ? or e.IdEntraineurAdjoint = ?) AND fdm.complete = 0";
    $dbh = $db->prepare($sReq);
    $dbh->execute([
            $idEntraineur,
            $idEntraineur,
            $idEntraineur,
            $idEntraineur           
        ]);
    return $dbh->fetchAll();

}*/

function Get_Matches_To_Complete($db, $idEntraineur)
{
    $sReq = "SELECT fdm.idfeuille, fdm.DateRencontre, fdm.Stade, e.NomEquipe as monEquipe, ea.NomEquipe as equipeAdverse 
            from feuilledematch as fdm 
            INNER JOIN equipes as e on fdm.IdEquipe1 = e.IdEquipe 
            INNER JOIN equipes as ea on ea.IdEquipe = fdm.IdEquipe2
            INNER JOIN feuillematchentraineur as fdme on fdme.idfeuilledematch = fdm.idfeuille 
            where (e.IdEntraineur = ? or e.IdEntraineurAdjoint = ?) AND fdm.complete = 0 AND fdme.complete = 0
            UNION
            SELECT fdm.idfeuille, fdm.DateRencontre, fdm.Stade, e.NomEquipe as monEquipe, ea.NomEquipe as equipeAdverse 
            from feuilledematch as fdm 
            INNER JOIN equipes as e on fdm.IdEquipe2 = e.IdEquipe 
            INNER JOIN equipes as ea on ea.IdEquipe = fdm.IdEquipe1
            INNER JOIN feuillematchentraineur as fdme on fdme.idfeuilledematch = fdm.idfeuille 
            where (e.IdEntraineur = ? or e.IdEntraineurAdjoint = ?) AND fdm.complete = 0 AND fdme.complete = 0";
    $dbh = $db->prepare($sReq);
    $dbh->execute([
            $idEntraineur,
            $idEntraineur,
            $idEntraineur,
            $idEntraineur           
        ]);
    return $dbh->fetchAll();

}

function Get_Players($db, $myTeam)
{
    $dbh = $db->prepare("SELECT * FROM joueurs JOIN postes ON joueurs.IdPostePredilection = postes.IdPoste WHERE idEquipe = ?");
    $dbh->execute([$myTeam]);
    $res = $dbh->fetchAll();
    return $res;
}

function Verify_TrainerAccess_To_MatchSheet($db, $idFeuille, $idEntraineur)
{
    $dbh = $db->prepare("SELECT e.idEntraineur FROM feuillematchentraineur AS fdm INNER JOIN  equipes as e ON e.idEquipe = fdm.idEquipe WHERE idFeuilleMatchEntraineur = ? AND e.idEntraineur = ?");
    $dbh->execute([
        $idFeuille,
        $idEntraineur,
    ]);
    $res = $dbh->fetchAll();
    if(count($res) == 0)
        return false;
    return true;
}

function Get_Feuille_Entraineur($db, $idfeuilleMatch, $idEntraineur)
{
    $dbh = $db->prepare("select fdme.IdFeuilleMatchEntraineur as idFeuilleE from feuillematchentraineur as fdme 
    INNER JOIN feuilledematch as fdm on fdm.IdFeuille = fdme.Idfeuilledematch
    INNER JOIN equipes as e on fdme.IdEquipe = e.IdEquipe
    Where e.IdEntraineur = ? and fdme.Idfeuilledematch = ?");
    $dbh->execute([$idEntraineur,
                $idfeuilleMatch 
                    ]);
    $res = $dbh->fetch();
    return $res['idFeuilleE'];
}

function Get_Players_From_Trainer($db, $idEntraineur)
{
    $dbh = $db->prepare("SELECT * FROM joueurs INNER JOIN postes ON joueurs.IdPostePredilection = postes.IdPoste 
                            INNER JOIN equipes as e ON e.IdEquipe = joueurs.IdEquipe
                            WHERE e.idEntraineur = ?");
    $dbh->execute([$idEntraineur]);
    $res = $dbh->fetchAll();
    return $res;

}

function Create_Liste_JoueursMatch($db, $idfeuilleEntraineur)
{
    $req = "INSERT INTO listejoueursmatch (IdFeuilleEntraineur) VALUES (?)";
    
    $dbh = $db -> prepare($req);
    if($dbh->execute([
        $idfeuilleEntraineur
    ]) == false)
    {
        $id = -1;
    }
    else
    {
        $id = $db->lastInsertId();
    } 
    return($id);
}

function Add_JoueurMatch($db, $idPlayer, $idPoste, $idListe, $isTitulaire)
{
    $sReq = "INSERT INTO joueursmatch (IdListeJoueursMatch, IdJoueur, IdPoste, Titulaire) VALUES (?, ?, ?, ?)";
    $dbh = $db->prepare($sReq);
    if($dbh->execute([
        $idListe,
        $idPlayer,
        $idPoste,
        $isTitulaire
    ]) == false)
    {
        //l'insert n'a pas marché, on traite l'erreur
        return "KO";
    }
    else
        return "OK"; 
}

function Update_FeuilleMatchEntraineur($db, $idfeuilleEntraineur, $idListeJoueur, $idCapitaine, $idSuppleant)
{
    $sReq = "UPDATE feuillematchentraineur SET IdCapitaine = ?, IdSuppleant = ?, complete = 1  WHERE IdFeuilleMatchEntraineur = ?";
    $dbh = $db->prepare($sReq);
    $res = $dbh->execute([
        $idCapitaine,
        $idSuppleant,
        $idfeuilleEntraineur
    ]);
    return $res;
}

function Get_Feuille_Resultats($db, $idfeuilleMatch)
{
    $dbh = $db->prepare("SELECT * FROM resultatmatch WHERE idfeuilledematch = ?");
    $dbh->execute([$idfeuilleMatch]);
    $res = $dbh->fetchAll();
    return $res;
}

function Insert_ResultatsMatch($db, $equipeGagnante, $scoreEquipeGagnante, $scoreEquipePerdante, $dureeMatch, $idFeuille)
{
    $sReq = "INSERT INTO resultatmatch (Idfeuilledematch, ScoreEquipeGagnante, ScoreEquipePerdante, DureeTotale, IdEquipeGagnante) VALUES (?, ?, ?, ?, ?)";
    $dbh = $db->prepare($sReq);
    if($dbh->execute([
        $idFeuille,
        $scoreEquipeGagnante,
        $scoreEquipePerdante,
        $dureeMatch,
        $equipeGagnante
    ]) == false)
    {
        //l'insert n'a pas marché, on traite l'erreur
        return "KO";
    }
    else
        return "OK"; 
}

function Update_ResultatsMatch($db, $equipeGagnante, $scoreEquipeGagnante, $scoreEquipePerdante, $dureeMatch, $idFeuilleMatch, $idFeuilleResultat)
{
    $sReq = "UPDATE resultatMatch SET idEquipeGagnante = ?, scoreEquipeGagnante = ?, scoreEquipePerdante = ?, DureeTotale = ?  WHERE IdResultatMatch = ? AND Idfeuilledematch = ?";
    $dbh = $db->prepare($sReq);
    $res = $dbh->execute([
        $equipeGagnante,
        $scoreEquipeGagnante,
        $scoreEquipePerdante,
        $dureeMatch,
        $idFeuilleResultat,
        $idFeuilleMatch
    ]);
    return $res;
}

function Get_Match_Buts($db, $idfeuilleMatch)
{
    $dbh = $db->prepare("SELECT b.IdBut, c.NomClub, j.Nom AS nomButeur, j.Prenom AS prenomButeur, j.NumeroMaillot AS numero, b.minute, b.contreSonCamp FROM buts AS b 
                        INNER JOIN joueurs AS j ON b.IdButeur = j.IdJoueur
                        INNER JOIN clubs AS c ON c.IdClub = b.IdEquipe 
                        WHERE b.IdMatch = ? ORDER BY b.minute");
    $dbh->execute([$idfeuilleMatch]);
    $res = $dbh->fetchAll();
    return $res;
}

function Get_Match_Players($db, $idfeuilleMatch)
{
    $dbh = $db->prepare("SELECT j.IdJoueur, j.Nom, j.Prenom, j.NumeroMaillot, j.IdEquipe, c.NomClub 
                            FROM joueursmatch as jm 
                            INNER JOIN listejoueursmatch as ljm on jm.IdListeJoueursMatch = ljm.IdListeJoueursMatch 
                            INNER JOIN feuillematchentraineur as fme on ljm.IdfeuilleEntraineur = fme.IdFeuilleMatchEntraineur 
                            INNER JOIN feuilledematch as fm on fm.IdFeuille = fme.Idfeuilledematch 
                            INNER JOIN joueurs as j on jm.IdJoueur = j.IdJoueur
                            INNER JOIN equipes as e on e.IdEquipe = j.IdEquipe
                            INNER JOIN clubs as c on e.IdClub = c.IdClub 
                            WHERE fme.Idfeuilledematch = ?");
    $dbh->execute([$idfeuilleMatch]);
    $res = $dbh->fetchAll();
    return $res;
}

function Add_But($db, $idEquipe, $idMatch, $idButeur, $contreSonCamp, $minute)
{
    $sReq = "INSERT INTO buts (IdEquipe, IdButeur, minute, contreSonCamp, IdMatch) VALUES (?, ?, ?, ?, ?)";
    $dbh = $db->prepare($sReq);
    if($dbh->execute([
        $idEquipe,
        $idButeur,
        $minute,
        $contreSonCamp,
        $idMatch
    ]) == false)
    {
        //l'insert n'a pas marché, on traite l'erreur
        return "KO";
    }
    else
        return "OK";
}

function Delete_But($db, $idBut)
{
    $dbh = $db->prepare("DELETE FROM buts WHERE IdBut = ?");
    $dbh->execute([$idBut]);
}

function Add_Changement($db, $idMatch, $idEquipe, $idJoueurSortant, $IdJoueurEntrant, $minute)
{
    $sReq = "INSERT INTO remplacements (IdFeuilleMatch, minute, IdEquipe, IdJoueurEntrant, IdJoueurSortant) VALUES (?, ?, ?, ?, ?)";
    $dbh = $db->prepare($sReq);
    if($dbh->execute([
        $idMatch,
        $minute,
        $idEquipe,
        $IdJoueurEntrant,
        $idJoueurSortant
    ]) == false)
    {
        //l'insert n'a pas marché, on traite l'erreur
        return "KO";
    }
    else
        return "OK";
}

function Get_Match_Changements($db, $idMatch)
{
    $dbh = $db->prepare("SELECT r.IdRemplacement, r.minute, c.NomClub, CONCAT(jE.Nom , ' ' , jE.Prenom) AS joueurEntrant, CONCAT(jS.Nom , ' ' , jS.Prenom) AS joueurSortant 
    FROM remplacements AS r 
    INNER JOIN feuilledematch AS fdm ON r.IdFeuilleMatch = fdm.IdFeuille 
    INNER JOIN clubs AS c ON c.IdClub = r.IdEquipe
    INNER JOIN joueurs AS jE ON jE.IdJoueur = r.IdJoueurEntrant
    INNER JOIN joueurs AS jS ON jS.IdJoueur = r.IdJoueurSortant
    WHERE fdm.IdFeuille = ? ORDER BY minute
    ");
    $dbh->execute([$idMatch]);
    $res = $dbh->fetchAll();
    return $res;
}

function Delete_Changement($db, $idChangement)
{
    $dbh = $db->prepare("DELETE FROM remplacements WHERE IdRemplacement = ?");
    if($dbh->execute([$idChangement]) == false)
        return "KO";
    else    
        return "OK";
}

function Add_Carton($db, $idMatch, $idCarton, $idEquipe, $idJoueurSanctionne, $minute)
{
    $sReq = "INSERT INTO cartons (IdMatch, IdEquipe, IdTypeCarton, IdJoueurSanctionne, Minute) VALUES (?, ?, ?, ?, ?)";
    $dbh = $db->prepare($sReq);
    if($dbh->execute([
        $idMatch,
        $idEquipe,
        $idCarton,
        $idJoueurSanctionne,
        $minute
    ]) == false)
    {
        //l'insert n'a pas marché, on traite l'erreur
        return "KO";
    }
    else
        return "OK";
}

function Get_Match_Cartons($db, $idMatch)
{
    $dbh = $db->prepare("SELECT ca.IdCarton, ca.minute, c.NomClub, CONCAT(j.Nom , ' ' , j.Prenom) AS joueurSanctionne, tc.Nom as NomCarton
    FROM cartons AS ca
    INNER JOIN feuilledematch AS fdm ON ca.IdMatch = fdm.IdFeuille 
    INNER JOIN clubs AS c ON c.IdClub = ca.IdEquipe
    INNER JOIN joueurs AS j ON j.IdJoueur = ca.IdJoueurSanctionne
    Inner Join typesCartons as tc on ca.IdTypeCarton = tc.IdTypeCarton
    WHERE fdm.IdFeuille = ? ORDER BY minute
    ");
    $dbh->execute([$idMatch]);
    $res = $dbh->fetchAll();
    return $res;
}

function Delete_Carton($db, $idCarton)
{
    $dbh = $db->prepare("DELETE FROM cartons WHERE IdCarton = ?");
    $dbh->execute([$idCarton]);
}

function Set_Resultats_complete($db, $idMatch)
{
    $sReq = "UPDATE feuilledematch SET complete = 1 WHERE IdFeuille = ?";
    $dbh = $db->prepare($sReq);
    $res = $dbh->execute([$idMatch]);
    return $res;
}
// function Get_Trainer_Team($db, $username)
// {
//     if($username != null && $username != "")
//     {
//         $dbh = $db->prepare("SELECT t.IdEquipe FROM users WHERE $username = ? AND ");
//         $dbh->execute([$newId]);
//         $res = $dbh->fetch();
//     }
//     return $res;
// }<?php

    function Get_Clubs($db)
    {
        $sReq = "SELECT * FROM clubs";
        $res = $db->query($sReq)->fetchAll();
        return $res;
    };

    function Get_Referees($db)
    {
        $sReq = "SELECT * FROM arbitres";
        $res = $db->query($sReq)->fetchAll();
        return $res;
    };

    // function Add_New_Match_Sheet($db, $date, $lieu, $equi1, $equi2, $arbitreP, $arbitreAss1, $arbitreAss2)
    // {
    //     $sReq = "INSERT INTO feuilledematch (DateRencontre, Lieu, IdEquipe1, IdEquipe2, IdArbitrePrinc, IdArbitreAss1, IdArbitreAss2) VALUES (?, ?, ?, ?, ?, ?, ?)";
    //     $dbh = $db->prepare($sReq);
    //     $dbh->execute([
    //         $date,
    //         $lieu,
    //         $equi1,
    //         $equi2,
    //         $arbitreP,
    //         $arbitreAss1,
    //         $arbitreAss2
    //     ]);
    // }

    //Doublon, a tester
    function Add_New_Match_Sheet($db, $DateRencontre, $Stade, $Equipe1, $Equipe2, $ArbitrePrinc, $ArbitreAss1, $ArbitreAss2)
    {
    
        $req = "INSERT INTO feuilledematch (DateRencontre, Stade, IdEquipe1, IdEquipe2, IdArbitrePrinc, IdArbitreAss1, IdArbitreAss2) VALUES (:DateRencontre, :Stade, :Equipe1, :Equipe2, :ArbitrePrinc, :ArbitreAss1, :ArbitreAss2)";
    
        $insertFeuilleDeMatch = $db -> prepare($req);
        if($insertFeuilleDeMatch -> execute(array(
            ':DateRencontre' => $DateRencontre,
            ':Stade' => $Stade,
            ':Equipe1' => $Equipe1,
            ':Equipe2' => $Equipe2,
            ':ArbitrePrinc' => $ArbitrePrinc,
            ':ArbitreAss1' => $ArbitreAss1,
            ':ArbitreAss2' => $ArbitreAss2
        )) == false)
        {
            $id = -1;
        }
        else
        {
            $id = $db->lastInsertId();
        } 
        return($id);
    }

function Get_Pending_Matchs($db)
{
    $sReq = "SELECT c1.NomClub as NomEquipe1, c2.NomClub as NomEquipe2, DateRencontre, Stade FROM feuilledematch AS f INNER JOIN clubs AS c1 ON f.IdEquipe1 = c1.IdClub INNER JOIN clubs as c2 on f.IdEquipe2 = c2.IdClub INNER JOIN arbitres as a1 on f.IdArbitrePrinc = a1.IdArbitre INNER JOIN arbitres as a2 on f.IdArbitreAss1 = a2.IdArbitre INNER JOIN arbitres as a3 on f.IdArbitreAss2 = a3.IdArbitre";
    $res = $db->query($sReq)->fetchAll();
    return $res;

}

function Create_User($db, $nom, $prenom, $id, $mail, $tel, $hmdp, $isAdmin)
{
    //on cherche avant tout dans la table users si le username n'est pas deja pris
    $approuved = $isAdmin ? true : false;
    $sReq = $db->prepare("SELECT userName FROM users WHERE userName = ?");
    $sReq->execute([$id]);
    $res = $sReq->fetch();
    //si on a pas de résultat, le username n'est pas pris
    //on peut créer l'utilisateur
    if($res == false)
    {
        $sReq = "INSERT INTO users (userName, hmdp, isAdmin, approved, mail, nom, prenom, numtel) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $dbh = $db->prepare($sReq);
            if($dbh->execute([
                $id,
                $hmdp,
                $isAdmin,
                $approuved,
                $mail,
                $nom,
                $prenom,
                $tel
            ]) == false)
            {
                //l'insert n'a pas marché, on traite l'erreur
                return "KO";
            }
            else//on renvoie un code succes
                return "OK";
    }
    else
    {
        //ce nom d'utilisateur est déja pris, on renvoie un code d'erreur
        //pour avertir l'utilisateur
        return "USEDNAME";
    }
}

function Get_User($db, $username, $isAdmin)
{
    $sUsername = filter_var($username, FILTER_SANITIZE_STRING);
    if($sUsername == false)
    {
        return null;
    }
    else
    {
        $dbh = $db->prepare("SELECT userName, hMdp, IdUser, approved FROM users WHERE userName = ? AND isAdmin = ?");
        $dbh->execute([$username, $isAdmin]);
    }
    return $dbh->fetch();
}

function VerifyAdminCreation($db, $codeAdmin)
{
    //va chercher le code admin en base de données et compare avec l'input
    //retourne true si le code est bon
    //false si code KO
    $codeAdmin = intval($codeAdmin);
    if($codeAdmin > 0)
    {
        $dbh = $db->prepare("SELECT CodeAdmin FROM codeadmin");
        $dbh->execute();
        $res = $dbh->fetch();
        return(password_verify($codeAdmin, $res["CodeAdmin"]));
    }
    return(false);
}

function Get_Match_infos($db, $idFeuille)
{
    $idFeuille = intval($idFeuille);
    if($idFeuille > 0)
    {
        $dbh = $db->prepare("SELECT DateRencontre, Stade, c1.NomClub as Equipe1, c2.NomClub as Equipe2  FROM feuilledematch AS f INNER JOIN clubs AS c1 ON f.IdEquipe1 = c1.IdClub INNER JOIN clubs as c2 on f.IdEquipe2 = c2.IdClub WHERE IdFeuille = ?");
        $dbh->execute([$idFeuille]);
    }
    return $dbh->fetch();
}

function Get_All_Matches_infos($db)
{
        $dbh = $db->prepare("SELECT DateRencontre, Stade, c1.NomClub as Equipe1, c2.NomClub as Equipe2, rm.ScoreEquipeGagnante, rm.ScoreEquipePerdante  FROM feuilledematch AS f INNER JOIN clubs AS c1 ON f.IdEquipe1 = c1.IdClub INNER JOIN clubs AS c2 on f.IdEquipe2 = c2.IdClub INNER JOIN resultatmatch AS rm ON f.IdFeuille = Idfeuilledematch WHERE complete = 1");
        $dbh->execute();

    return $dbh->fetchAll();
}

//Récupère les données pour la page detailsMatch

function Get_All_Infos($db)
{
        $dbh = $db->prepare("SELECT DateRencontre, Stade, c1.NomClub as Equipe1, c2.NomClub as Equipe2, rm.ScoreEquipeGagnante, rm.ScoreEquipePerdante  FROM feuilledematch AS f INNER JOIN clubs AS c1 ON f.IdEquipe1 = c1.IdClub INNER JOIN clubs AS c2 on f.IdEquipe2 = c2.IdClub INNER JOIN resultatmatch AS rm ON f.IdFeuille = Idfeuilledematch WHERE complete = 1");
        $dbh->execute();

    return $dbh->fetchAll();
}


function Get_All_Postes($db)
{
    $sReq = "SELECT * FROM postes";
    $res = $db->query($sReq)->fetchAll();
    return $res;
}

//recupère la team liée à l'idEquipe dans la bdd: table equipes
function Get_team($db, $idequipe)
{
    $newId = intval($idequipe);
    if(is_int($newId) && $newId > 0)
    {
        $dbh = $db->prepare("SELECT IdEquipe, NomEquipe FROM equipes WHERE IdEquipe = ?");
        $dbh->execute([$newId]);
        $res = $dbh->fetch();
    }
    return $res;
}

//Ajoute un joueur dans la BDD:  table joueurs
function Create_Player($db, $nom, $prenom, $numMaillot, $idPoste, $equipe)
{
    $sReq = "INSERT INTO joueurs (Nom, Prenom, NumeroMaillot, IdEquipe, IdPostePredilection) VALUES (?, ?, ?, ?, ?)";
    $dbh = $db->prepare($sReq);
    if($dbh->execute([
        $nom,
        $prenom,
        $numMaillot,
        $equipe,
        $idPoste
    ]) == false)
    {
        //l'insert n'a pas marché, on traite l'erreur
        return "KO";
    }
    else
        return "OK"; 
}

function Create_All_Sheets($db, $idFeuille, $idEquipe1, $idEquipe2)
{
    $res = "MATCHCREATED";
    $sReq = "INSERT INTO feuillematchentraineur (Idfeuilledematch, IdEquipe) VALUES (?, ?)";
    $dbh = $db->prepare($sReq);
    if($dbh->execute([
        $idFeuille,
        $idEquipe1
    ]) == false)
    {
        //l'insert n'a pas marché, on traite l'erreur
        $res = "KO";
    }
    $sReq = "INSERT INTO feuillematchentraineur (Idfeuilledematch, IdEquipe) VALUES (?, ?)";
    $dbh = $db->prepare($sReq);
    if($dbh->execute([
        $idFeuille,
        $idEquipe2
    ]) == false)
    {
        //l'insert n'a pas marché, on traite l'erreur
        $res = "KO";
    }
    return $res;
}

function Get_pending_trainers($db)
{

    $dbh = $db->prepare("SELECT * FROM users WHERE isAdmin = false AND approved = 0 LIMIT 5");
    $dbh->execute();
    return $dbh->fetchAll();
}

function Get_denied_trainers($db)
{

    $dbh = $db->prepare("SELECT * FROM users WHERE isAdmin = false AND approved = -1");
    $dbh->execute();
    return $dbh->fetchAll();
}


//Get players from Id Trainer//
function Get_My_Players($db, $myTeam)
{
    $dbh = $db->prepare("SELECT * FROM `joueurs` JOIN postes ON joueurs.IdPostePredilection = postes.IdPoste WHERE idEquipe = ?");
    $dbh->execute([$myTeam]);
    $res = $dbh->fetchAll();
    return $res;
}



function Get_Trainer_ID($db, $boolAdmin, $IdUser){
        
    // $res = "";//
    if($boolAdmin == false) {
        $dbh = $db->prepare("SELECT IdEntraineur FROM entraineurs WHERE IdUser = ? ");
        $dbh->execute([$IdUser]);
        $res = $dbh->fetch();
        if($res == false) {
            $res = "";
        }
    } 
    return $res['IdEntraineur'];
}

//Get Team from an Id Trainer//
function Get_IDTeam_FromTrainer($db, $idEntraineur){
    $dbh = $db->prepare("SELECT IdEquipe FROM equipes WHERE IdEntraineur = ? ");
    $dbh->execute([$idEntraineur]);
    $res = $dbh->fetchall();
    if($res == false) 
    {
        return "";
    }
    else 
    {
        return $res;
    }
}

//Get Team from Trainer//
function Get_Team_FromTrainer($db, $idEntraineur){
    $dbh = $db->prepare("SELECT * FROM equipes WHERE IdEntraineur = ? ");
    $dbh->execute([$idEntraineur]);
    $res = $dbh->fetchall();
    if($res == false) 
    {
        return "";
    }
    else 
    {
        return $res;
    }
}
    

function Accept_Or_Decline_User($db, $iduser, $approved)
{
    $approvedNbr = ($approved == "true" ? 1 : -1);
    
    $sReq = "UPDATE users SET approved = ? WHERE IdUser = ?";
    $dbh = $db->prepare($sReq);
    $dbh->execute([
        $approvedNbr,
        $iduser
    ]);
    $sReq = "INSERT INTO entraineurs (IdUser) VALUES (?)";
    $dbh = $db->prepare($sReq);
    $dbh->execute([
        $iduser
    ]);
    
}

/*function Get_Matches_To_Complete($db, $idEntraineur)
{
    $sReq =" SELECT fdm.DateRencontre, fdm.Lieu, e.NomEquipe as monEquipe, ea.NomEquipe as equipeAdverse 
            from feuilledematch as fdm 
            INNER JOIN equipes as e on fdm.IdEquipe1 = e.IdEquipe 
            INNER JOIN equipes as ea on ea.IdEquipe = fdm.IdEquipe2 
            where (e.IdEntraineur = ? or e.IdEntraineurAdjoint = ?) AND fdm.complete = 0
            UNION
            SELECT fdm.DateRencontre, fdm.Lieu, e.NomEquipe as monEquipe, ea.NomEquipe as equipeAdverse 
            from feuilledematch as fdm 
            INNER JOIN equipes as e on fdm.IdEquipe2 = e.IdEquipe 
            INNER JOIN equipes as ea on ea.IdEquipe = fdm.IdEquipe1 
            where (e.IdEntraineur = ? or e.IdEntraineurAdjoint = ?) AND fdm.complete = 0";
    $dbh = $db->prepare($sReq);
    $dbh->execute([
            $idEntraineur,
            $idEntraineur,
            $idEntraineur,
            $idEntraineur           
        ]);
    return $dbh->fetchAll();

}*/

function Get_Matches_To_Complete($db, $idEntraineur)
{
    $sReq = "SELECT fdm.idfeuille, fdm.DateRencontre, fdm.Stade, e.NomEquipe as monEquipe, ea.NomEquipe as equipeAdverse 
            from feuilledematch as fdm 
            INNER JOIN equipes as e on fdm.IdEquipe1 = e.IdEquipe 
            INNER JOIN equipes as ea on ea.IdEquipe = fdm.IdEquipe2
            INNER JOIN feuillematchentraineur as fdme on fdme.idfeuilledematch = fdm.idfeuille 
            where (e.IdEntraineur = ? or e.IdEntraineurAdjoint = ?) AND fdm.complete = 0 AND fdme.complete = 0
            UNION
            SELECT fdm.idfeuille, fdm.DateRencontre, fdm.Stade, e.NomEquipe as monEquipe, ea.NomEquipe as equipeAdverse 
            from feuilledematch as fdm 
            INNER JOIN equipes as e on fdm.IdEquipe2 = e.IdEquipe 
            INNER JOIN equipes as ea on ea.IdEquipe = fdm.IdEquipe1
            INNER JOIN feuillematchentraineur as fdme on fdme.idfeuilledematch = fdm.idfeuille 
            where (e.IdEntraineur = ? or e.IdEntraineurAdjoint = ?) AND fdm.complete = 0 AND fdme.complete = 0";
    $dbh = $db->prepare($sReq);
    $dbh->execute([
            $idEntraineur,
            $idEntraineur,
            $idEntraineur,
            $idEntraineur           
        ]);
    return $dbh->fetchAll();

}


function Get_Players($db, $myTeam)
{
    $dbh = $db->prepare("SELECT * FROM joueurs JOIN postes ON joueurs.IdPostePredilection = postes.IdPoste WHERE idEquipe = ?");
    $dbh->execute([$myTeam]);
    $res = $dbh->fetchAll();
    return $res;
}


// Delete player from its ID//
function Delete_Player($db, $idPlayer)
{
    $dbh = $db->prepare("DELETE FROM joueurs WHERE IdJoueur = ?");
    $dbh->execute([$idPlayer]);
}


// Update player from its ID//
function Update_Player($db, $nom, $prenom, $numMaillot, $equipe, $idPoste, $idJoueur)
{
    $sReq = "UPDATE joueurs SET Nom = ?, Prenom = ?, NumeroMaillot = ?, IdEquipe = ?, IdPostePredilection = ? WHERE IdJoueur = ?";
    $dbh = $db->prepare($sReq);
    $dbh->execute([
        $nom,
        $prenom,
        $numMaillot,
        $equipe,
        $idPoste,
        $idJoueur
    ]); 
}


function Get_A_Player($db, $idJoueur)
{
    $sReq = "SELECT * FROM joueurs WHERE IdJoueur = ?";
    $dbh = $db->prepare($sReq);
    $dbh->execute([$idJoueur]);
    $res = $dbh->fetchAll();
    return $res;
}



// function Get_Trainer_Team($db, $username)
// {
//     if($username != null && $username != "")
//     {
//         $dbh = $db->prepare("SELECT t.IdEquipe FROM users WHERE $username = ? AND ");
//         $dbh->execute([$newId]);
//         $res = $dbh->fetch();
//     }
//     return $res;
// }