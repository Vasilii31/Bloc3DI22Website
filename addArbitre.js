const addArbitreForm = document.getElementById("formArbitre");
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
    addArbitreForm.reset();
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