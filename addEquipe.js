
const addEquipeForm = document.getElementById("formClub");
const SelectClub = document.getElementById("InputClub");
const clubWarning = document.getElementById("clubSelectWarning");

addEquipeForm.addEventListener("submit", (e) => {
    //on empeche la page de submit le formulaire directement
    e.preventDefault();

    if(SelectClub.value == "" )
    {
        clubWarning.style = "display: flex;"
        return;
    }
    else
    {
        addEquipeForm.submit();
    }
  });