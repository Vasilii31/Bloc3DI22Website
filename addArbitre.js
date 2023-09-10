addArbitreForm = document.getElementById("formArbitre");
const InputNom = document.getElementById("InputNom");
const InputNationalite = document.getElementById("InputNationalite");
const InputId = document.getElementById("InputId");
const submitbutton = document.getElementById("submitbtn"); 
const formArbitre = document.getElementById("AjoutArbitre");

function show_Arbitre_Form()
{
    InputId.setAttribute("value", "");
    InputNom.setAttribute("value", "");
    InputNationalite.setAttribute("value", "");
    submitbutton.setAttribute("value", "Ajouter");
    formArbitre.style = "display:flex;"
}

function To_Modify_Arbitre_Form(idArbitre)
{
    let nom = document.getElementById("nomArbitre"+idArbitre).innerHTML;
    let nationalite = document.getElementById("nationaliteArbitre"+idArbitre).innerHTML;    
    InputId.setAttribute("value", idArbitre);
    InputNom.setAttribute("value", nom);
    InputNationalite.setAttribute("value", nationalite);
    submitbutton.setAttribute("value", "Modifier");
    formArbitre.style = "display:flex;";
}

addArbitreForm.addEventListener("submit", (e) => {
    //on empeche la page de submit le formulaire directement
    e.preventDefault();

    if(!nom_verif())
    {
        //on ne submit pas si tout les champs ne sont pas conformes
        console.log("Non conforme");
        return;
    }
    else
    {
        addArbitreForm.submit();
    }
  });

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