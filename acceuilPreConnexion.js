const displayform = pE('displayForm');
const forLogin = pE('forLogin');
const loginForm = pE('loginForm');
const forRegister = pE('forRegister');
const registerForm = pE('registerForm');
const formContainer = pE('formContainer');
const registerButton = pE('registerButton');
displayform.addEventListener('click', showForm);

registerButton.addEventListener('click', GlobalVerif);

forLogin.addEventListener('click', () => {
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

function pE(e)
{
    return document.getElementById(e);
}

function showForm()
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
    }
}