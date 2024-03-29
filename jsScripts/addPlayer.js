const addPlayerForm = document.getElementById("add_player_form");

addPlayerForm.addEventListener("submit", (e) => {
    //on empeche la page de submit le formulaire directement
    e.preventDefault();

    if(!nom_verif() || !prenom_verif() || !poste_verif())
    {
        //on ne submit pas si tout les champs ne sont pas conformes
        console.log("Non conforme");
        return;
    }
    else
    {
        addPlayerForm.submit();
    }
  });

function poste_verif()
{   
    const posteSelector = document.getElementById("posteSelector");
    if(posteSelector != null)
    {       
        if(posteSelector.value == "")
        {
            posteSelector.style = "border: 2px solid red;";
            return false;
        }
        else
        {
            posteSelector.style = "border-color: black";
            return true;
        }        
    }
    else
        return false;
}

function nom_verif()
{
    const nomInput = document.getElementById("InputNom");
    if(nomInput != null)
    {
       if(!name_test_regex(nomInput.value) || !script_protection(nomInput.value))
        {
            nomInput.style = "border: 2px solid red;";
            return(false);
        }    
        else
        {   
            nomInput.style = "border-color: black";
            return(true);
        }  
    }
    else
    {
        return false;
    }
    
}

function prenom_verif()
{
    const nomInput = document.getElementById("InputPrenom");
    if(nomInput != null)
    {
        if(!name_test_regex(nomInput.value) || !script_protection(nomInput.value))
        {
            nomInput.style = "border: 2px solid red;";
            return(false);
        }    
        else
        {
            nomInput.style = "border-color: black";
            return(true);
        }
    }
    else
        return false;
}

//Plus nécessaire : le controle front end se fait via l'input type number
// function num_Maillot_verif()
// {
//     const numMaillot = document.getElementById("InputNum");
//     console.log(num_maillot_test_regex(numMaillot.value));
//     console.log(typeof numMaillot.value);
//     if(!num_maillot_test_regex(numMaillot.value) || !script_protection(numMaillot.value))
//     {
//         numMaillot.style = "border: 2px solid red;";
//         return(false);
//     }    
//     else
//     {
//         numMaillot.style = "border-color: black";
//         return(true);
//     }
// }