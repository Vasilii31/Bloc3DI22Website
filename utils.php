<?php
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
            header("location: /auth.php");
        }

        if($admin == true)
        {
            if(!is_admin())
            {
                //pour l'instant on a pas de page d'erreur 
                header("location: /deniedAccess.php?admin=false");  
            }       
        }
        else
        {
            if(is_admin())
            {
                //pour l'instant on a pas de page d'erreur 
                header("location: /deniedAccess.php?admin=true");
            }
        }
    }
