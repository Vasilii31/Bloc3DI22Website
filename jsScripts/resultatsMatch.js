
const ButForm = document.getElementById("ajoutButForm");
const ChangementForm = document.getElementById("ajoutChangementForm");
const CartonForm = document.getElementById("ajoutCartonForm");
const FeuilleResultatsForm = document.getElementById("validerResultatsForm");

ButForm.addEventListener("submit", (e) => {
    //on empeche la page de submit le formulaire directement
    e.preventDefault();
    if(document.getElementById("ButCheckBox").checked == true)
    {
        document.getElementById("ButCheckBoxValue").setAttribute('value', "1");
    }else{
        document.getElementById("ButCheckBoxValue").setAttribute('value', "0");
    }
    
    ButForm.submit();
  });

function show_AjoutBut_form()
{
    const formBut = document.getElementById("AjoutBut");
    formBut.style = "display:flex;"
}

function show_AjoutChangement_form()
{
    const formChange = document.getElementById("AjoutChangement");
    formChange.style = "display:flex;"
}

function show_AjoutCarton_form()
{
    const formCarton = document.getElementById("AjoutCarton");
    formCarton.style = "display:flex;"
}


FeuilleResultatsForm.addEventListener("submit", (e) => {
    //on empeche la page de submit le formulaire directement
    e.preventDefault();
    //On fait les différents tests de validation de résultats
    //Si tout est bon on submit
    FeuilleResultatsForm.submit();

    //sinon on affiche les erreurs
  });

function changeJoueurSelection(equipe)
{
    if(equipe == 2)
    {
        document.getElementById("buteurSelector").innerHTML = equipe2;
    }
    else
    {
        document.getElementById("buteurSelector").innerHTML = equipe1;
    }
}

function changeJoueurSanctionneSelection(equipe)
{
    if(equipe == 2)
    {
        document.getElementById("JoueurSanctionneSelector").innerHTML = equipe2;
    }
    else
    {
        document.getElementById("JoueurSanctionneSelector").innerHTML = equipe1;
    }
}

function changeJoueurChangementSelection(equipe)
{
    if(equipe == 2)
    {
        document.getElementById("joueurEntrantSelector").innerHTML = equipe2;
        document.getElementById("joueurSortantSelector").innerHTML = equipe2;
    }
    else
    {
        document.getElementById("joueurEntrantSelector").innerHTML = equipe1;
        document.getElementById("joueurSortantSelector").innerHTML = equipe1;
    }
}