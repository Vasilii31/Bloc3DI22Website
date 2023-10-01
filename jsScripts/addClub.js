const addClubForm = document.getElementById("formClub");
const InputNom = document.getElementById("InputNom");
const InputId = document.getElementById("InputId");
const submitbutton = document.getElementById("submitbtn"); 
const formClub = document.getElementById("AjoutClub");
const addButton = document.getElementById("add-button");


function show_Club_Form()
{

    InputId.setAttribute("value", "");
    InputNom.setAttribute("value", "");
    addClubForm.reset();
    submitbutton.setAttribute("value", "Ajouter");
    formClub.style = "display:flex;"
    addButton.style.display = "none";
}

function To_Modify_Club_Form(idClub)
{
    let nom = document.getElementById("nomClub"+idClub).innerHTML; 
    InputId.setAttribute("value", idClub);
    InputNom.setAttribute("value", nom);
    submitbutton.setAttribute("value", "Modifier");
    formClub.style = "display:flex;";
}