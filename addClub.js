const addClubForm = document.getElementById("formClub");
const InputNom = document.getElementById("InputNom");
const InputId = document.getElementById("InputId");
const submitbutton = document.getElementById("submitbtn"); 
const formClub = document.getElementById("AjoutClub");

/*function show_Club_Form()
{

    InputId.setAttribute("value", "");
    InputNom.setAttribute("value", "");
    addArbitreForm.reset();
    submitbutton.setAttribute("value", "Ajouter");
    formClub.style = "display:flex;"
}*/

function To_Modify_Club_Form(idClub)
{
    let nom = document.getElementById("nomClub"+idClub).innerHTML; 
    InputId.setAttribute("value", idClub);
    InputNom.setAttribute("value", nom);
    submitbutton.setAttribute("value", "Modifier");
    formClub.style = "display:flex;";
}