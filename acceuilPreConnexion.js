/*const displayform = pE('displayForm');
const forLogin = pE('forLogin');
const loginForm = pE('loginForm');
const forRegister = pE('forRegister');
const registerForm = pE('registerForm');
const formContainer = pE('formContainer');
const registerButton = pE('registerButton');
displayform.addEventListener('click', showForm);

registerButton.addEventListener('click', GlobalVerif);*/

//TEST
const equip2s = pE("equip2selector");
const equip1s = pE("equip1selector");
const testDate = pE('inputDate');
var reliquatEquipe2;
var reliquatEquipe1;

function dateHandler(date)
{
    const equip1 = pE('equipe1');
    equip1.classList.remove('hidden');
    console.log("Vous avez inséré la date : " + date);
}

function equip1Handler(equipe)
{
    if(equipe == "")
    {
        console.log("remise à zéro");
        if(reliquatEquipe2 != null)
        {
            equip2s.add(reliquatEquipe2, equip2s[reliquatEquipe2.value]);
            reliquatEquipe2 = null;
        }
    }
    else
    {
        if(reliquatEquipe2 != null)
        {
            equip2s.add(reliquatEquipe2, equip2s[reliquatEquipe2.value]);
        }
        reliquatEquipe2 = pE("equip2opt"+equipe);
        console.log(reliquatEquipe2);
        equip2s.remove(equipe);
        const equip2 = pE('equipe2');
        equip2.classList.remove('hidden');
        console.log("Vous avez selectionné l'équipe : " + equipe);
    }    
}
/*testDate.addEventListener('oninput', () => {
    console.log("La date a changé");
})*/

function equip2Handler(equipe)
{
    if(equipe == "")
    {
        console.log("remise à zéro");
        if(reliquatEquipe1 != null)
        {
            equip1s.add(reliquatEquipe1, equip1s[reliquatEquipe1.value]);
            reliquatEquipe1 = null;
        }
    }
    else
    {
        if(reliquatEquipe1 != null)
        {
            equip1s.add(reliquatEquipe1, equip1s[reliquatEquipe1.value]);
        }
        reliquatEquipe1 = pE("equip1opt"+equipe);
        console.log(reliquatEquipe1);
        equip1s.remove(equipe);

    }
}
//TEST



const equip1 = pE("equip1selector");
    console.log(equip1);

/*forLogin.addEventListener('click', () => {
    forLogin.classList.add('active');
    forRegister.classList.remove('active');
    if(loginForm.classList.contains('toggleForm'))
    {
        formContainer.style.transform = 'translate(0%)';
        formContainer.style.transition = 'transform .5s';
        registerForm.classList.add('toggleForm');
        loginForm.classList.remove('toggleForm');
    }
})

forRegister.addEventListener('click', () => {
    forLogin.classList.remove('active');
    forRegister.classList.add('active');
    if(registerForm.classList.contains('toggleForm'))
    {
        formContainer.style.transform = 'translate(-100%)';
        formContainer.style.transition = 'transform .5s';
        registerForm.classList.remove('toggleForm');
        loginForm.classList.add('toggleForm');
    }
})

*/

function pE(e)
{
    return document.getElementById(e);
}

/*function showForm()
{
    document.querySelector('.form-wrapper .card').classList.toggle('show');
}

//Librairie de vérification d'input a faire ?
function GlobalVerif()
{
    var elem = registerForm.elements;
    console.log(elem.length);
    for(var i = 0; i < elem.length; i++)
    {
        console.log(elem[i].getAttribute("placeholder"));
        console.log(elem[i].value);
        if(elem[i].valueMissing == true)
        {       
            alert("champ " + elem[i].getAttribute("placeholder") + " vide !");
            return;
        }
    }
    
    
    //for(var i = 0; i < registerForm)
    //on fait différentes vérifications avant de valider l'inscription
    //1 : On vérifie que tout les champs sont remplis ===>plus besoin avec required dans le html
    //2 : On vérifie champ par champ : caractères valides uniquement et taille du champ
    //3 : adresse email valide ********@*****.**
    //4 : mot de passe et confirmation sont identiques.
}

function Register()
{
    if(GlobalVerif() != "OK")
    {
        //prompt avec valeur de retour de global verif pour message d'erreur ?
    }
    else{
        //on tente de créer le profil. Si erreur, ramener sur la page de connexion avec un message d'erreur
        //exemple : ce nom d'utilisateur existe déjà
    }*/