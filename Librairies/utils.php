<?php

    require_once("../Librairies/Crud.php");

    function init_php_session()
    {
        //s'il n'y a pas de session en cours
        if(!session_id())
        {
            //on démarre une session
            if(!session_start())
            {
                //le démarrage de session a échoué
                //gérer l'erreur plus tard
                return false;
            }
            else{
                //on régénère l'identifiant, true pour effacer les anciens id
                session_regenerate_id(true);
                return true;
            }
            
        }
        //si une session est déja initialisée, pas besoin de créer de session
        return false;
    }

    function is_logged()
    {
        if(isset($_SESSION['username']))
            return true;
        else
            return false;
    }

    function is_admin()
    {
        if(is_logged())
        {
            if(isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == true)
                return true;
        }
        return false;
    }

    //on stoppe la session en cours
    function clean_php_session()
    {
        session_unset();
        session_destroy();
    }

    //cette fonction verifie les droits d'acces à la page. 
    //Si l'utilisateur n'est pas log : On redirige vers la page d'authentification
    //si l'utilisateur est log mais n'a pas les bons droits d'acces, on redirige vers la page d'erreur
    function grant_access($admin)
    {
        if(!is_logged())
        {
            header("location: ../Views/auth.php");
            return;
        }

        if($admin == true)
        {
            if(!is_admin())
            {
                //pour l'instant on a pas de page d'erreur 
                header("location: ../Views/deniedAccess.php?admin=false");  
            }       
        }
        else
        {
            if(is_admin())
            {
                //pour l'instant on a pas de page d'erreur 
                header("location: ../Views/deniedAccess.php?admin=true");
            }
        }
    }

    function SignIn($db, $infoArray)
    {
        //string verification ici ?
        //if(is_string($infoArray["nom"]) == false || is_string($infoArray["prenom"]) == false || )
        $boolAdmin = ($infoArray["admin"] == "true") ? true : false;
        if($boolAdmin)
        {
            $validCode = VerifyAdminCreation($db, $infoArray["createAdmin"]);
            if(!$validCode)
                return "INVALIDADMINCODE";
        }
        // on hash le mot de passe :
        $hmdp = password_hash($infoArray['mdp'], PASSWORD_BCRYPT);
        //et on créé l'utilisateur
        //TO DO gerer la creation d'entraineur temporaire a valider par un administrateur
        $res = Create_User($db, $infoArray["nom"], $infoArray["prenom"],
        $infoArray["identifiant"], $infoArray["mail"], $infoArray["telephone"], $hmdp, $boolAdmin);
        
        if($res == "OK")
        {
            if($boolAdmin)
                return "CREATEADMINOK";
            else
                return "CREATETRAINEROK";
        }
        else
            return($res);
    }

    function Login($db, $infoArray)
    {
        $boolAdmin = ($infoArray["admin"] == "true") ? true : false; 

        $res = Get_User($db, $infoArray["username"], $boolAdmin);
        if($res != false)
        {
            var_dump($infoArray);
            var_dump($res);
            var_dump(password_verify($infoArray["mdp"], $res['hMdp'])); 
            if(password_verify($infoArray["mdp"], $res["hMdp"]))
            {
                if($res['approved'] == 1){

                    init_php_session();
                    //recuperer l'id user ?
                    $_SESSION['username'] = $infoArray['username'];
                    $_SESSION['nom'] = $res['nom'];
                    $_SESSION['prenom'] = $res['prenom'];
                    $_SESSION['isAdmin'] = $boolAdmin;
                    $_SESSION['IdUser'] = $res['IdUser'];
                    if(!$boolAdmin)
                    {
                        $_SESSION['IdEntraineur'] = Get_Trainer_ID($db, $boolAdmin, $res['IdUser']);
                    }    
                    
                    
                    return "OK";
                } 
                elseif($res['approved'] == -1) 
                {
                    return "KONOTAPPROVED";
                }
                else
                {
                    return "KOAWAITAPPROVAL";
                }
            }
            else
            {
                return "KOIDPWD";   
            }
        }
        else
            return "KOIDPWD";
    }

    function GlobalsInfosMatch($db, $idFeuille)
    {
        $dbRes = Get_Match_infos($db, $idFeuille);
        if($dbRes != null)
        {
            $newDate = date("d-m-Y", strtotime($dbRes['DateRencontre']));  
            $output = "Rencontre du ".$newDate." :</br>".$dbRes["Equipe1"]." contre ".$dbRes["Equipe2"];
        }
        return $output;
    }

    //a voir si utile
    function verif_Access_TrainerToTeam($db, $idequipe, $username)
    {
        $idTeamTrainer = Get_Trainer_Team($db, $username);
        if($idTeamTrainer == $idequipe)
            return true;
        return false;
    }


