<?php

    function Get_Clubs($db)
    {
        $sReq = "SELECT * FROM clubs";
        $res = $db->query($sReq)->fetchAll();
        return $res;
    };

    function Get_teams($db)
    {
        $sReq = "SELECT IdEquipe, NomEquipe  FROM equipes";
        $res = $db->query($sReq)->fetchAll();
        return $res;
    }

    function Get_Referees($db)
    {
        $sReq = "SELECT * FROM arbitres";
        $res = $db->query($sReq)->fetchAll();
        return $res;
    };

    // function Add_New_Match_Sheet($db, $date, $lieu, $equi1, $equi2, $arbitreP, $arbitreAss1, $arbitreAss2)
    // {
    //     $sReq = "INSERT INTO feuilledematch (DateRencontre, Stade, IdEquipe1, IdEquipe2, IdArbitrePrinc, IdArbitreAss1, IdArbitreAss2) VALUES (?, ?, ?, ?, ?, ?, ?)";
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
        $dbh = $db->prepare("SELECT userName, hMdp, IdUser, approved, nom, prenom  FROM users WHERE userName = ? AND isAdmin = ?");
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
        $dbh = $db->prepare("SELECT f.IdFeuille, DateRencontre, Stade, c1.NomClub as Equipe1, c2.NomClub as Equipe2, rm.ScoreEquipeGagnante, rm.ScoreEquipePerdante  FROM feuilledematch AS f INNER JOIN clubs AS c1 ON f.IdEquipe1 = c1.IdClub INNER JOIN clubs AS c2 on f.IdEquipe2 = c2.IdClub INNER JOIN resultatmatch AS rm ON f.IdFeuille = Idfeuilledematch WHERE complete = 1 ORDER BY DateRencontre DESC");
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

//Get ID Team from an Id Trainer//
function Get_IDTeam_FromTrainer($db, $idEntraineur){
    $dbh = $db->prepare("SELECT IdEquipe FROM equipes WHERE IdEntraineur = ? OR IdEntraineurAdjoint = ?");
    $dbh->execute([$idEntraineur, $idEntraineur]);
    $res = $dbh->fetch();
    if($res == false) 
    {
        return "";
    }
    else 
    {
        return $res['IdEquipe'];
    }
}

//Get Team from an Id Trainer//
function Get_Team_FromTrainer($db, $idEntraineur){
    $dbh = $db->prepare("SELECT * FROM equipes WHERE IdEntraineur = ? OR IdEntraineurAdjoint = ?");
    $dbh->execute([$idEntraineur, $idEntraineur]);
    $res = $dbh->fetch();
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
    $sReq =" SELECT fdm.DateRencontre, fdm.Stade, e.NomEquipe as monEquipe, ea.NomEquipe as equipeAdverse 
            from feuilledematch as fdm 
            INNER JOIN equipes as e on fdm.IdEquipe1 = e.IdEquipe 
            INNER JOIN equipes as ea on ea.IdEquipe = fdm.IdEquipe2 
            where (e.IdEntraineur = ? or e.IdEntraineurAdjoint = ?) AND fdm.complete = 0
            UNION
            SELECT fdm.DateRencontre, fdm.Stade, e.NomEquipe as monEquipe, ea.NomEquipe as equipeAdverse 
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
    $sReq = "SELECT fdme.IdFeuilleMatchEntraineur, f.IdFeuille, f.DateRencontre, f.Stade, e1.NomEquipe AS Equipe1, e2.NomEquipe AS Equipe2 FROM feuilledematch AS f 
            INNER JOIN feuillematchentraineur AS fdme ON f.IdFeuille = fdme.Idfeuilledematch
            INNER JOIN equipes AS e ON fdme.IdEquipe = e.IdEquipe
            INNER JOIN equipes AS e1 ON e1.IdEquipe = f.IdEquipe1
            INNER JOIN equipes AS e2 ON e2.IdEquipe = f.IdEquipe2
            WHERE (e.IdEntraineur = ? OR e.IdEntraineurAdjoint = ?)
            AND fdme.complete = 0";
    $dbh = $db->prepare($sReq);
    $dbh->execute([
            $idEntraineur,
            $idEntraineur,          
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
    Where (e.IdEntraineur = ? OR e.IdEntraineurAdjoint = ?) and fdme.Idfeuilledematch = ?");
    $dbh->execute([
                    $idEntraineur,
                    $idEntraineur,
                    $idfeuilleMatch]);
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
    $dbh = $db->prepare("SELECT b.IdBut, b.IdButeur, c.NomClub, e.NomEquipe, j.Nom AS nomButeur, j.Prenom AS prenomButeur, j.NumeroMaillot AS numero, b.minute, b.contreSonCamp FROM buts AS b 
                        INNER JOIN joueurs AS j ON b.IdButeur = j.IdJoueur
                        INNER JOIN clubs AS c ON c.IdClub = b.IdEquipe
                        INNER JOIN equipes AS e ON e.IdEquipe = b.IdEquipe
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
    $res= $dbh->execute([
        $nom,
        $prenom,
        $numMaillot,
        $equipe,
        $idPoste,
        $idJoueur
    ]); 
    return $res;
}



function Get_A_Player($db, $idJoueur)
{
    $sReq = "SELECT * FROM joueurs JOIN postes on joueurs.IdPostePredilection = postes.IdPoste WHERE IdJoueur = ?";
    $dbh = $db->prepare($sReq);
    $dbh->execute([$idJoueur]);
    $res = $dbh->fetch();
    return $res;
}

function InsertArbitre($db, $nom, $nationalite)
{
    $sReq = "INSERT INTO arbitres (NomArbitre, Nationalite) VALUES (?, ?)";
    $dbh = $db->prepare($sReq);
    if($dbh->execute([
        $nom,
        $nationalite
    ]) == false)
    {
        //l'insert n'a pas marché, on traite l'erreur
        return "KO";
    }
    else
        return "OK";
}

function ModifyArbitre($db, $id, $nom, $nationalite)
{
    $sReq = "UPDATE arbitres SET NomArbitre = ?, Nationalite = ? WHERE IdArbitre = ?";
    $dbh = $db->prepare($sReq);
    if($dbh->execute([
        $nom,
        $nationalite,
        $id
    ]) == false)
    {
        //l'insert n'a pas marché, on traite l'erreur
        return "KO";
    }
    else
        return "OK";
}

function DeleteArbitre($db, $id)
{
    $dbh = $db->prepare("DELETE FROM arbitres WHERE IdArbitre = ?");
    if($dbh->execute([$id]) == false)
    {
        return "KO";
    }
    else
        return "OK";
}

function InsertClub($db, $nom)
{
    $sReq = "INSERT INTO clubs (NomClub) VALUES (?)";
    $dbh = $db->prepare($sReq);
    if($dbh->execute([$nom]) == false)
    {
        //l'insert n'a pas marché, on traite l'erreur
        return "KO";
    }
    else
        return "OK";
}

function ModifyClub($db, $id, $nom)
{
    $sReq = "UPDATE clubs SET NomClub = ? WHERE IdClub = ?";
    $dbh = $db->prepare($sReq);
    if($dbh->execute([
        $nom,
        $id
    ]) == false)
    {
        //l'insert n'a pas marché, on traite l'erreur
        return "KO";
    }
    else
        return "OK";
}

function Get_Equipes_And_Clubs($db)
{
    $sReq = "SELECT * FROM equipes as e 
            INNER JOIN clubs as c on e.IdClub = c.IdClub";
    $dbh = $db->prepare($sReq);
    $dbh->execute([]);
    $res = $dbh->fetchAll();
    return $res;
}

function InsertEquipe($db, $idclub, $nom)
{
    $sReq = "INSERT INTO equipes (IdClub, NomEquipe) VALUES (?, ?)";
    $dbh = $db->prepare($sReq);
    if($dbh->execute([
        $idclub,
        $nom
        ]) == false)
    {
        //l'insert n'a pas marché, on traite l'erreur
        return "KO";
    }
    else
        return "OK";
}

function Get_All_Trainers($db)
{
    $sReq = "SELECT * FROM entraineurs as e INNER JOIN users as u on e.IdUser = u.IdUser";
    $dbh = $db->prepare($sReq);
    $dbh->execute([]);
    $res = $dbh->fetchAll();
    return $res;
}

function Update_Team_Trainer($db, $idequipe, $idEntraineur)
{
    $sReq = "UPDATE equipes SET IdEntraineur = ? WHERE IdEquipe = ?";
    $dbh = $db->prepare($sReq);
    if($dbh->execute([
        $idEntraineur,
        $idequipe
    ]) == false)
    {
        //l'insert n'a pas marché, on traite l'erreur
        return "KO";
    }
    else
        return "OK";
}

function Update_Team_TrainerAdjoint($db, $idequipe, $idEntraineur)
{
    $sReq = "UPDATE equipes SET IdEntraineurAdjoint = ? WHERE IdEquipe = ?";
    $dbh = $db->prepare($sReq);
    if($dbh->execute([
        $idEntraineur,
        $idequipe
    ]) == false)
    {
        //l'insert n'a pas marché, on traite l'erreur
        return "KO";
    }
    else
        return "OK";
}

function Get_Matchs_Attente_Entraineurs($db)
{
    $sReq = "SELECT fdm.IdFeuille, fdm.DateRencontre, fdm.Stade, e1.NomEquipe as equipe1, e2.NomEquipe as equipe2 from feuilledematch as fdm
                INNER JOIN feuillematchentraineur as fdme on fdm.IdEquipe1 = fdme.IdEquipe
                INNER JOIN equipes as e1 on fdm.IdEquipe1 = e1.IdEquipe
                INNER JOIN equipes as e2 on fdm.IdEquipe2 = e2.IdEquipe
                where fdme.complete = 0 and fdme.Idfeuilledematch = fdm.IdFeuille and fdm.complete = 0
                UNION
                SELECT fdm.IdFeuille, fdm.DateRencontre, fdm.Stade, e1.NomEquipe as equipe1, e2.NomEquipe as equipe2 from feuilledematch as fdm
                INNER JOIN feuillematchentraineur as fdme on fdm.IdEquipe2 = fdme.IdEquipe
                INNER JOIN equipes as e1 on fdm.IdEquipe1 = e1.IdEquipe
                INNER JOIN equipes as e2 on fdm.IdEquipe2 = e2.IdEquipe
                where fdme.complete = 0 and fdme.Idfeuilledematch = fdm.IdFeuille and fdm.complete = 0
                GROUP by IdFeuille";
    $dbh = $db->prepare($sReq);
    $dbh->execute([]);
    $res = $dbh->fetchAll();
    return $res;
}

 
function Get_Matchs_Attente_Resultats($db)
{
    $sReq = "SELECT fdm.IdFeuille, fdm.DateRencontre, fdm.Stade, e1.NomEquipe as equipe1, e2.NomEquipe as equipe2 from feuilledematch as fdm
        INNER JOIN equipes as e1 on fdm.IdEquipe1 = e1.IdEquipe
        INNER JOIN equipes as e2 on fdm.IdEquipe2 = e2.IdEquipe
        WHERE DateRencontre <= CURRENT_DATE() and complete = 0";
    $dbh = $db->prepare($sReq);
    $dbh->execute([]);
    $res = $dbh->fetchAll();
    return $res;
}

function Get_Historiques_Team_Matches($db, $idEntraineur)
{
    $sReq = "SELECT f.IdFeuille, DateRencontre, Stade, c1.NomClub as Equipe1, c2.NomClub as Equipe2, rm.ScoreEquipeGagnante, rm.ScoreEquipePerdante  
        FROM feuilledematch AS f 
        INNER JOIN clubs AS c1 ON f.IdEquipe1 = c1.IdClub 
        INNER JOIN clubs AS c2 on f.IdEquipe2 = c2.IdClub 
        INNER JOIN resultatmatch AS rm ON f.IdFeuille = Idfeuilledematch 
        INNER JOIN equipes as e on f.IdEquipe1 = e.IdEquipe
        WHERE complete = 1 AND (e.IdEntraineur = ? or e.IdEntraineurAdjoint = ?)
        UNION
        SELECT f.IdFeuille, DateRencontre, Stade, c1.NomClub as Equipe1, c2.NomClub as Equipe2, rm.ScoreEquipeGagnante, rm.ScoreEquipePerdante  
        FROM feuilledematch AS f 
        INNER JOIN clubs AS c1 ON f.IdEquipe1 = c1.IdClub 
        INNER JOIN clubs AS c2 on f.IdEquipe2 = c2.IdClub 
        INNER JOIN resultatmatch AS rm ON f.IdFeuille = Idfeuilledematch 
        INNER JOIN equipes as e on f.IdEquipe2 = e.IdEquipe
        WHERE complete = 1 AND (e.IdEntraineur = ? or e.IdEntraineurAdjoint = ?)
        GROUP BY f.IdFeuille";
    $dbh = $db->prepare($sReq);
    $dbh->execute([
        $idEntraineur,
        $idEntraineur,
        $idEntraineur,
        $idEntraineur
    ]);
    $res = $dbh->fetchAll();
    return $res;
}

function Get_Details_Match_Termine($db, $idFeuille)
{
    $sReq = "SELECT f.IdFeuille, DateRencontre, Stade, c1.NomClub as Equipe1, c2.NomClub as Equipe2, rm.ScoreEquipeGagnante, rm.ScoreEquipePerdante, rm.DureeTotale as duree 
        FROM feuilledematch AS f 
        INNER JOIN clubs AS c1 ON f.IdEquipe1 = c1.IdClub 
        INNER JOIN clubs AS c2 on f.IdEquipe2 = c2.IdClub 
        INNER JOIN resultatmatch AS rm ON f.IdFeuille = Idfeuilledematch 
        INNER JOIN equipes as e on f.IdEquipe1 = e.IdEquipe
        WHERE f.complete = 1 AND f.idFeuille = ?
        UNION
        SELECT f.IdFeuille, DateRencontre, Stade, c1.NomClub as Equipe1, c2.NomClub as Equipe2, rm.ScoreEquipeGagnante, rm.ScoreEquipePerdante, rm.DureeTotale as duree  
        FROM feuilledematch AS f 
        INNER JOIN clubs AS c1 ON f.IdEquipe1 = c1.IdClub 
        INNER JOIN clubs AS c2 on f.IdEquipe2 = c2.IdClub 
        INNER JOIN resultatmatch AS rm ON f.IdFeuille = Idfeuilledematch 
        INNER JOIN equipes as e on f.IdEquipe2 = e.IdEquipe
        WHERE f.complete = 1 AND f.idFeuille = ?
        GROUP BY f.IdFeuille";
    $dbh = $db->prepare($sReq);
    $dbh->execute([
        $idFeuille,
        $idFeuille
    ]);
    $res = $dbh->fetch();
    return $res;
}

function Get_IdTeam_From_Player($db, $idplayer){
    $dbh = $db->prepare("SELECT IdEquipe from joueurs where IdJoueur = ?");
    $dbh->execute([$idplayer]);
    $res = $dbh->fetch();
    if($res == false) 
    {
        return "KO";
    }
    else 
    {
        return $res;
    }
}

function delete_Arbitre($db, $idArbitre)
{
    $dbh = $db->prepare("DELETE FROM arbitres WHERE IdArbitre = ?");
    $dbh->execute([$idArbitre]);
}

function Get_Matches_Completed_by_Trainer($db, $idEntraineur)
{
    $sReq = "SELECT f.IdFeuille, f.DateRencontre, f.Stade, fe.IdFeuilleMatchEntraineur, e1.NomEquipe as Equipe1, e2.NomEquipe as Equipe2
                FROM feuilledematch as f 
                INNER JOIN feuillematchentraineur as fe on f.IdFeuille = fe.Idfeuilledematch
                INNER JOIN equipes as e on fe.IdEquipe = e.IdEquipe
                INNER JOIN equipes as e1 on f.IdEquipe1 = e1.IdEquipe
                INNER JOIN equipes as e2 on f.IdEquipe2 = e2.IdEquipe
                WHERE f.complete = 0 AND fe.complete = 1 and f.DateRencontre >= CURRENT_DATE() AND (e.IdEntraineur = ? or e.IdEntraineurAdjoint = ?)";
    $dbh = $db->prepare($sReq);
    $dbh->execute([$idEntraineur,
                    $idEntraineur]);
    $res = $dbh->fetchAll();
    return $res;
}

function Get_match_arbitres($db, $idmatch)
{
    $sReq = "SELECT a.NomArbitre as NomArbitrePrincipal, a.Nationalite as NationaliteArbitrePrincipal,
        a2.NomArbitre as NomArbitreAssistant1, a2.Nationalite as NationaliteArbitreAssistant1,
        a3.NomArbitre as NomArbitreAssistant2, a3.Nationalite as NationaliteArbitreAssistant2
        FROM feuilledematch as f
        INNER JOIN arbitres as a on a.IdArbitre = f.IdArbitrePrinc
        INNER JOIN arbitres as a2 on a2.IdArbitre = f.IdArbitreAss1
        INNER JOIN arbitres as a3 on a3.IdArbitre = f.IdArbitreAss2
        WHERE f.IdFeuille = ?";
    $dbh = $db->prepare($sReq);
    $dbh->execute([$idmatch]);
    $res = $dbh->fetch();
    return $res;
}

function Get_All_Infos_Match_Appli($db, $idFeuille)
{
    $sReq = "SELECT f.IdFeuille, f.DateRencontre, f.Stade, rm.ScoreEquipeGagnante, rm.ScoreEquipePerdante,
                rm.DureeTotale as duree, 
                CASE WHEN f.IdEquipe1 = rm.IdEquipeGagnante THEN e1.NomEquipe ELSE e2.NomEquipe END as vainqueur,
                CASE WHEN f.IdEquipe1 != rm.IdEquipeGagnante THEN e1.NomEquipe ELSE e2.NomEquipe END as perdant
                FROM feuilledematch AS f 
                INNER JOIN resultatmatch as rm on f.IdFeuille = rm.Idfeuilledematch
                INNER JOIN equipes as e1 on e1.IdEquipe = f.IdEquipe1
                INNER JOIN equipes as e2 on e2.IdEquipe = f.IdEquipe2
                WHERE f.IdFeuille = ?";
    $dbh = $db->prepare($sReq);
    $dbh->execute([$idFeuille]);
    $res = $dbh->fetch();
    return $res;
}

function Get_Infos_Equipes($db, $idmatch)
{
    $sReq = "SELECT e1.IdEquipe as IdEquipe1, e2.IdEquipe as IdEquipe2, e1.NomEquipe as NomEquipe1, e2.NomEquipe as NomEquipe2, 
        CONCAT(u1.nom, ' ', u1.prenom) as entraineurEquipe1, CONCAT(u2.nom, ' ', u2.prenom) as entraineurEquipe2,
        ''  as entraineurAdjointEquipe1, '' as entraineurAdjointEquipe2
        FROM feuilledematch as f
        JOIN equipes as e1 ON f.IdEquipe1 = e1.IdEquipe
        JOIN equipes as e2 ON f.IdEquipe2 = e2.IdEquipe
        JOIN entraineurs as en1 ON e1.IdEntraineur = en1.IdEntraineur
        JOIN entraineurs as en2 ON e2.IdEntraineur = en2.IdEntraineur
        JOIN users as u1 on u1.IdUser = en1.IdUser
        JOIN users as u2 on u2.IdUser = en2.IdUser
        WHERE f.IdFeuille = ?";
    $dbh = $db->prepare($sReq);
    $dbh->execute([$idmatch]);
    $res = $dbh->fetch();
    return $res;
}

function Get_Team_MatchesStats($db, $idequipe, $season)
{
    $sReq = "SELECT count(*) as MatchesPlayed, 
                (select count(*)
                FROM feuilledematch as f INNER JOIN resultatmatch as rm on rm.Idfeuilledematch = f.IdFeuille
                WHERE YEAR(f.DateRencontre) = ? and f.complete = 1 AND f.DateRencontre <= CURRENT_DATE() 
                AND (f.IdEquipe1 = ? or f.IdEquipe2 = ?) and rm.IdEquipeGagnante = ?) as MatchesWon
    FROM feuilledematch as f INNER JOIN resultatmatch as rm on rm.Idfeuilledematch = f.IdFeuille
    WHERE YEAR(f.DateRencontre) = ? and f.complete = 1 AND f.DateRencontre <= CURRENT_DATE() 
    AND (f.IdEquipe1 = ? or f.IdEquipe2 = ?)";
    $dbh = $db->prepare($sReq);
    $dbh->execute([
            $season,
            $idequipe,
            $idequipe,
            $idequipe,
            $season,
            $idequipe,
            $idequipe]);
    $res = $dbh->fetch();
    return $res;
}

function Get_Team_Buts_Marques_Stats($db, $idequipe, $season)
{
    $sReq = "SELECT count(*) as nombreDeButsMarques
    FROM feuilledematch as f 
    INNER join buts as b on b.IdMatch = f.IdFeuille
    where b.IdEquipe = ?  and YEAR(f.DateRencontre) = ?";
    $dbh = $db->prepare($sReq);
    $dbh->execute([
            $idequipe,
            $season]);
    $res = $dbh->fetch();
    return $res;
}

function Get_Team_CartonsStats($db, $idequipe, $season)
{
    $sReq = "SELECT count(*) as nombreDeCartons
    FROM feuilledematch as f 
    INNER join cartons as c on c.IdMatch = f.IdFeuille
    where c.IdEquipe = ?  and YEAR(f.DateRencontre) = ?";
    $dbh = $db->prepare($sReq);
    $dbh->execute([
            $idequipe,
            $season]);
    $res = $dbh->fetch();
    return $res;
}

function Get_Team_Buts_Encaisses_Stats($db, $idequipe, $season)
{
    $sReq = "SELECT count(*) as nombreDeButsEncaisses FROM buts as b 
        INNER JOIN feuilledematch as f on f.IdFeuille = b.IdMatch
        Where (f.IdEquipe1 = ? or f.IdEquipe2 = ?) and b.IdEquipe != ? 
        and b.IdMatch = f.IdFeuille and YEAR(f.DateRencontre) = ? And b.contreSonCamp = 0";
    $dbh = $db->prepare($sReq);
    $dbh->execute([
            $idequipe,
            $idequipe,
            $idequipe,
            $season]);
    $res = $dbh->fetch();
    return $res;
}

function Get_Best_Team_Buteurs($db, $idequipe, $season)
{
    $sReq = "SELECT  j.IdJoueur, j.Nom, j.Prenom, 
                (SELECT COUNT(*) 
                FROM buts as b1 
                INNER JOIN feuilledematch as f on b1.IdMatch = f.IdFeuille 
                WHERE IdButeur = j.IdJoueur AND YEAR(f.DateRencontre) = ?) as butsMarques 	
            FROM joueurs as j  INNER JOIN buts as b on j.IdJoueur = b.IdButeur
	        WHERE j.IdEquipe = ? GROUP by j.IdJoueur ORDER by butsMarques DESC LIMIT 5";
    $dbh = $db->prepare($sReq);
    $dbh->execute([
            $season,
            $idequipe]);
    $res = $dbh->fetchAll();
    return $res;
}

function Get_Best_Team_MatchSaison($db, $idequipe, $season)
{
    $sReq = "SELECT f.IdFeuille, max((rm.ScoreEquipeGagnante - rm.ScoreEquipePerdante)) as scoreDiff, f.DateRencontre, e1.NomEquipe as nomEquipe1, e2.NomEquipe as nomEquipe2
        FROM resultatmatch as rm 
        INNER JOIN feuilledematch as f on f.IdFeuille = rm.Idfeuilledematch
        INNER JOIN equipes as e1 on f.IdEquipe1 = e1.IdEquipe
        INNER JOIN equipes as e2 on f.IdEquipe2 = e2.IdEquipe
        where rm.IdEquipeGagnante = ? and YEAR(f.DateRencontre) = ?";
    $dbh = $db->prepare($sReq);
    $dbh->execute([
            $idequipe,
            $season]);
    $res = $dbh->fetch();
    return $res;
}

function Get_Worst_Team_MatchSaison($db, $idequipe, $season)
{
    $sReq = "SELECT max(scoreDiff) as scoreDifference, t.* from (
        SELECT f.IdFeuille, (rm.ScoreEquipeGagnante - rm.ScoreEquipePerdante) as scoreDiff, f.DateRencontre, e1.NomEquipe as nomEquipe1, e2.NomEquipe as nomEquipe2
        FROM resultatmatch as rm 
        INNER JOIN feuilledematch as f on f.IdFeuille = rm.Idfeuilledematch
        INNER JOIN equipes as e1 on f.IdEquipe1 = e1.IdEquipe
        INNER JOIN equipes as e2 on f.IdEquipe2 = e2.IdEquipe
        where (f.IdEquipe1 = ? or f.IdEquipe2 = ?) and rm.IdEquipeGagnante != ? and YEAR(f.DateRencontre) = ?) as t";
    $dbh = $db->prepare($sReq);
    $dbh->execute([
            $idequipe,
            $idequipe,
            $idequipe,
            $season]);
    $res = $dbh->fetch();
    return $res;
}
/*function Get_Match_General_infos($db, $idFeuille)
{
    $idFeuille = intval($idFeuille);
    if($idFeuille > 0)
    {
        $dbh = $db->prepare("SELECT DateRencontre, Stade, c1.NomClub as Equipe1, c2.NomClub as Equipe2, c1.IdClub as IdEquipe1, c2.IdClub as IdEquipe2,   FROM feuilledematch AS f INNER JOIN clubs AS c1 ON f.IdEquipe1 = c1.IdClub INNER JOIN clubs as c2 on f.IdEquipe2 = c2.IdClub WHERE IdFeuille = ?");
        $dbh->execute([$idFeuille]);
    }
    return $dbh->fetch();
}*/
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

// function get_WinnerTeam($db, $IdFeuilledeMatch)
// {
//     $sReq = "SELECT * FROM `equipes` INNER JOIN resultatmatch ON equipes.IdEquipe = resultatmatch.IdEquipeGagnante WHERE Idfeuilledematch = ?";
//     $dbh = $db->prepare($sReq);
//     $dbh->execute([$IdFeuilledeMatch]);
//     $res = $dbh->fetchAll();
//     return $res;
// }

// function get_Equipe1($db, $IdFeuilledeMatch)
// {
//     $sReq = "SELECT * FROM equipes JOIN feuilledematch ON equipes.IdEquipe = feuilledematch.IdEquipe1 WHERE Idfeuille = ?";
//     $dbh = $db->prepare($sReq);
//     $dbh->execute([$IdFeuilledeMatch]);
//     $res = $dbh->fetchAll();
//     return $res;
// }

// function get_Equipe2($db, $IdFeuilledeMatch)
// {
//     $sReq = "SELECT * FROM equipes JOIN feuilledematch ON equipes.IdEquipe = feuilledematch.IdEquipe2 WHERE Idfeuille = ?";
//     $dbh = $db->prepare($sReq);
//     $dbh->execute([$IdFeuilledeMatch]);
//     $res = $dbh->fetchAll();
//     return $res;
// }

