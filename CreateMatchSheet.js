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
function pE(e)
{
    return document.getElementById(e);
}

const equip2s = pE("equip2selector");
const equip1s = pE("equip1selector");
const arbitrePrincS = pE("arbitrePrincSelector");
const arbitreAss1S = pE("arbitreAssSelector1");
const arbitreAss2S = pE("arbitreAssSelector2");
const testDate = pE('inputDate');
var reliquatEquipe2;
var reliquatEquipe1;
let reliquatArbitrePrinc = [];
let reliquatArbitreAss1 = [];
let reliquatArbitreAss2 = [];
var arbitrePrincPrecedent;
var arbitreAss1Precedent;
var arbitreAss2Precedent;
var previousArbitrePrinc="";
var previousArbitreAss1="";
var previousArbitreAss2="";


function reinitSelector(selectorToModify, reliquatToModify, previousValue)
{
    reliquatToModify.forEach((reliquat) => 
        {
            console.log(reliquat);
            if(reliquat.value == previousValue) 
            {
                selectorToModify.add(reliquat, selectorToModify[reliquat.value]); // On l'ajoute au sélecteur Arbitre Assistant 1
            }
            const index = reliquatToModify.indexOf(reliquat); //Connaître l'index du reliquat en question
            console.log(index);
            if (index > -1) //Si indexOf ne trouve rien, il renvoie -1
            {
                reliquatToModify.splice(index, 1); //On supprime la case à l'index où on l'a trouvée, le 2nd param indique que l'on retire 1 élém
            }
            console.log(reliquatToModify);
        })
}

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
        reliquatEquipe1 = pE("equip1opt"+equipe); //on récupère l'équipe sélectionnée dans le select 1 pour la mettre dans le reliquat
        console.log(reliquatEquipe1);
        equip1s.remove(equipe); //on retire l'équipe sélectionnée du sélect Equipe 1
        console.log("Vous avez selectionné l'équipe : " + equipe);

    }
}



function arbitrePrincHandler(arbitre) 
{
    
    reinitSelector(arbitreAss1S, reliquatArbitreAss1, previousArbitrePrinc);
    reinitSelector(arbitreAss2S, reliquatArbitreAss2, previousArbitrePrinc);

    if (arbitre != "")
    {
        var reliquatTemp = pE("arbitreAss1Opt"+arbitre); //On cherche dans notre html l'option du sélect ArbitreAss1 qui contient notre valeur arbitre
        reliquatArbitreAss1.push(reliquatTemp); //Je le push dans reliquatArbitreAss1
        reliquatTemp.remove();
        reliquatTemp = pE("arbitreAss2Opt"+arbitre);
        reliquatArbitreAss2.push(reliquatTemp);
        reliquatTemp.remove();
        console.log(reliquatArbitreAss1); 
        console.log(reliquatArbitreAss2); 
        // const arbitreAss1 = pE('arbitreAss1');
        // arbitreAss1.classList.remove('hidden');
        console.log("Vous avez sélectionné l'arbitre : " + arbitre);
    }

    previousArbitrePrinc = arbitre;
}



function arbitreAss1Handler(arbitre) 
{
     
    reinitSelector(arbitrePrincS, reliquatArbitrePrinc, previousArbitreAss1);
    reinitSelector(arbitreAss2S, reliquatArbitreAss2, previousArbitreAss1);
    
    if (arbitre != "")
    {
        var reliquatTemp = pE("arbitrePrincOpt"+arbitre); //On cherche dans notre html l'option du sélect ArbitreAss1 qui contient notre valeur arbitre
        reliquatArbitrePrinc.push(reliquatTemp); //Je le push dans reliquatArbitreAss1
        reliquatTemp.remove();
        reliquatTemp = pE("arbitreAss2Opt"+arbitre);
        reliquatArbitreAss2.push(reliquatTemp);
        reliquatTemp.remove();
        console.log(reliquatArbitrePrinc); 
        console.log(reliquatArbitreAss2); 

        // const arbitreAss2 = pE('arbitreAss2');
        // arbitreAss2.classList.remove('hidden');
        console.log("Vous avez sélectionné l'arbitre : " + arbitre);
    }

    previousArbitreAss1 = arbitre;
}

// function getOptionAss2() 
// {
//     var arbitreAss2Selector = document.getElementById("arbitreAss2Selector");
//     var arbitreAss2Selected = arbitreAss2Selector.value;
    
//     console.log("Option précédente : " + arbitreAss2Precedent);
//     console.log("Option sélectionnée : " + arbitreAss2Selected);
    
//     arbitreAss2Precedent = arbitreAss2Selected;
// }

function arbitreAss2Handler(arbitre) 
{
        
    reinitSelector(arbitrePrincS, reliquatArbitrePrinc, previousArbitreAss2);
    reinitSelector(arbitreAss1S, reliquatArbitreAss1, previousArbitreAss2);
    
    if (arbitre != "")
    {
        var reliquatTemp = pE("arbitrePrincOpt"+arbitre); 
        reliquatArbitrePrinc.push(reliquatTemp); 
        reliquatTemp.remove();
        reliquatTemp = pE("arbitreAss1Opt"+arbitre);
        reliquatArbitreAss1.push(reliquatTemp);
        reliquatTemp.remove();
        console.log(reliquatArbitrePrinc); 
        console.log(reliquatArbitreAss1); 

        console.log("Vous avez sélectionné l'arbitre : " + arbitre);
    }

    previousArbitreAss2 = arbitre;
}

// NE FONCTIONNENT PAS CAR ON A 3 POSSIBILITES
// function arbitrePrincHandler(arbitre)
// {
//     if(arbitre == "")
//     {
//         console.log("remise à zéro");
//         if(reliquatArbitreAss1 != null)
//         {
//             arbitreAss1S.add(reliquatArbitreAss1, arbitreAss1S[reliquatArbitreAss1.value]);
//             reliquatArbitreAss1 = null;
//         }
//         if(reliquatArbitreAss2 != null)
//         {
//             arbitreAss2S.add(reliquatArbitreAss2, arbitreAss2S[reliquatArbitreAss2.value]);
//             reliquatArbitreAss2 = null;
//         }
//     }
//     else
//     {
        
//         if(reliquatArbitreAss1 != null)
//         {
//             arbitreAss1S.add(reliquatArbitreAss1, arbitreAss1S[reliquatArbitreAss1.value]);
//         }
//         reliquatArbitreAss1 = pE("arbitreAss1Opt"+arbitre);
//         console.log(reliquatArbitreAss1);
//         arbitreAss1S.remove(arbitre);
//         if(reliquatArbitreAss2 != null)
//         {
//             arbitreAss2S.add(reliquatArbitreAss2, arbitreAss2S[reliquatArbitreAss2.value]);
//         }
//         reliquatArbitreAss2 = pE("arbitreAss2Opt"+arbitre);
//         console.log(reliquatArbitreAss2);
//         arbitreAss2S.remove(arbitre);
//     }
// }

// function arbitreAss1Handler(arbitre)
// {
//     if(arbitre == "")
//     {
//         console.log("remise à zéro");
//         if(reliquatArbitrePrinc != null)
//         {
//             arbitrePrincS.add(reliquatArbitrePrinc, arbitrePrincS[reliquatArbitrePrinc.value]);
//             reliquatArbitrePrinc = null;
//         }
//         if(reliquatAss2 != null)
//         {
//             arbitreAss2S.add(reliquatArbitreAss2, arbitreAss2S[reliquatArbitreAss2.value]);
//             reliquatArbitreAss2 = null;
//         }
//     }
//     else
//     {
//         if(reliquatArbitrePrinc != null)
//         {
//             arbitrePrincS.add(reliquatArbitrePrinc, arbitrePrincS[reliquatArbitrePrinc.value]);
//         }
//         reliquatArbitrePrinc = pE("arbitrePrincOpt"+arbitre);
//         console.log(reliquatArbitrePrinc);
//         arbitrePrincS.remove(arbitre);
//         if(reliquatArbitreAss2 != null)
//         {
//             arbitreAss2S.add(reliquatArbitreAss2, arbitreAss2S[reliquatArbitreAss2.value]);
//         }
//         reliquatArbitreAss2 = pE("arbitreAss2Opt"+arbitre);
//         console.log(reliquatArbitreAss2);
//         arbitreAss2S.remove(arbitre);

//     }
// }


// function arbitreAss2Handler(arbitre)
// {
//     if(arbitre == "")
//     {
//         console.log("remise à zéro");
//         if(reliquatArbitrePrinc != null)
//         {
//             arbitrePrincS.add(reliquatArbitrePrinc, arbitrePrincS[reliquatArbitrePrinc.value]);
//             reliquatArbitrePrinc = null;
//         }
//         if(reliquatArbitreAss1 != null)
//         {
//             arbitreAss1S.add(reliquatArbitreAss1, arbitreAss1S[reliquatArbitreAss1.value]);
//             reliquatArbitreAss1 = null;
//         }
//     }
//     else
//     {
//         if(reliquatArbitrePrinc != null)
//         {
//             arbitrePrincS.add(reliquatArbitrePrinc, arbitrePrincS[reliquatArbitrePrinc.value]);
//         }
//         reliquatArbitrePrinc = pE("arbitrePrincOpt"+arbitre);
//         console.log(reliquatArbitrePrinc);
//         arbitrePrincS.remove(arbitre);
//         if(reliquatArbitreAss1 != null)
//         {
//             arbitreAss1S.add(reliquatArbitreAss1, arbitreAss1S[reliquatArbitreAss1.value]);
//         }
//         reliquatArbitreAss1 = pE("arbitreAss1Opt"+arbitre);
//         console.log(reliquatArbitreAss1);
//         arbitreAss1S.remove(arbitre);

//     }
// }

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
