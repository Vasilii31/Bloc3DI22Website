const displayform = pE('displayForm');
const displayformTrainer = pE('displayFormTrainer');
const forLogin = pE('forLogin');
const loginForm = pE('loginForm');
const forRegister = pE('forRegister');
const registerForm = pE('registerForm');
const formContainer = pE('formContainer');
const registerButton = pE('registerButton');
const formTitle = pE("card-title");
displayform.addEventListener('click', showFormAdmin);
displayformTrainer.addEventListener('click', showFormTrainer);


function pE(e)
{
    return document.getElementById(e);
}

function showFormAdmin()
{
    document.querySelector('.form-wrapper .card').classList.toggle('show');
    var codeAdminInput = pE("codeAdmin");
    var adminFormValue = pE("boolAdmin");
    var boolAdminlog = pE("boolAdminLog");
    boolAdminlog.value = "true";
    adminFormValue.value = "true";
    formTitle.innerHTML = "Espace Organisateur";
    codeAdminInput.style = "display:flex;"
}

function showFormTrainer()
{
    document.querySelector('.form-wrapper .card').classList.toggle('show');
    var codeAdminInput = pE("codeAdmin");
    var adminFormValue = pE("boolAdmin");
    var boolAdminlog = pE("boolAdminLog");
    boolAdminlog.value = "false";
    adminFormValue.value = "false";
    formTitle.innerHTML = "Espace Entraineur";
    codeAdminInput.style = "display:none;"
    
}

//est appelé quand on clique sur le bouton submit
registerForm.addEventListener("submit", (e) => {
    //on empeche la page de submit le formulaire directement
    e.preventDefault();

    if(!text_validation("fnInput", "fnError") || !text_validation("lnInput", "lnError") || !userName_validation() || !email_validation() || !phone_validation() || !password_validation())
    {
        return;
    }
    else
    {
        registerForm.submit();
    }
  });

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

function password_validation()
{
    var pwd = pE("pwd");
    var confirmPwd = pE("cpwd");
    const passRegex = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/;
    var unError = pE("pwdError");

    if(!script_protection(pwd.value) || !script_protection(confirmPwd.value) || !passRegex.test(pwd.value) || pwd.value != confirmPwd.value)
    {
        if(pwd.value != confirmPwd.value)
        {
            unError.innerHTML = "Le mot de passe et la confirmation doivent être identiques.";
        }
        else
        {
            unError.innerHTML = "Minimum 8 caractères, au moins une lettre, un nombre et un caractère spécial.";
        }
        unError.style = "display:flex;";
        pwd.style = "border: 2px solid red;";
        confirmPwd.style = "border: 2px solid red;";
        pwd.focus();
        return false;
    }
    else
    {
        unError.style = "display:none;";
        pwd.style = "border-color: black";
        confirmPwd.style = "border-color: black";
    }
    return true;
}

function email_validation() 
{
    var mail = pE("mailInput");
    const mailRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    var mailError = pE("mailError");
    if (!mailRegex.test(mail.value))
    {
        mailError.style = "display:flex;"; 
        mail.style = "border: 2px solid red;";
        mail.focus();
        return false;
    }
    else
    {
        mailError.style = "display:none;";
        mail.style = "border-color: black";       
    }
    return true;
}

function text_validation(inputId, errorField)
{
    var input = pE(inputId);
    var inputRegex = /^[A-Za-z-éè]+$/;
    var validInput = input.value.match(inputRegex);
    var error = pE(errorField);
    if(!script_protection(input.value) || validInput == null)
    {
        error.style = "display:flex;";
        input.style = "border: 2px solid red;";
        input.focus();
        return false;
    }
    else
    {
        error.style = "display:none;";
        input.style = "border-color: black";       
    }
    return true;
}

function userName_validation()
{
    var input = pE("usernameInput");
    //on doit avoir au moins une lettre, on accepte les chiffres et uniquement les - _ ou . comme caractères spéciaux 
    var inputRegex = /^[a-zA-Z][a-zA-Z\d\-_\.]*$|^[a-zA-Z\d\-_\.]*[a-zA-Z]$/
    var validInput = input.value.match(inputRegex);
    var unError = pE("userNameError");
    if(!script_protection(input.value) || validInput == null)
    {
        unError.style = "display:flex;";
        input.style = "border: 2px solid red;";
        input.focus();
        return false;
    }
    else{
        unError.style = "display:none;";
        input.style = "border-color: black";
    }
    return true;
}

function phone_validation()
{
    var phoneInput = pE("telInput");
    var phoneRGEX = /^[(]{0,1}[0-9]{3}[)]{0,1}[-\s\.]{0,1}[0-9]{3}[-\s\.]{0,1}[0-9]{4}$/;
    var phoneResult = phoneRGEX.test(phoneInput.value);
    var unError = pE("telError");
    if(!script_protection(phoneInput.value) || !phoneResult)
    {
        unError.style = "display:flex;";
        phoneInput.style = "border: 2px solid red;";
        phoneInput.focus();
        return false;
    }
    else{
        unError.style = "display:none;";
        phoneInput.style = "border-color: black";
    }
    return true;
}

//protection contre l'injection de script mais probablement incorrecte
function script_protection(str)
{
    if(str.includes("<script>") || str.includes(";"))
        return false;
    return true;
}

function show_Password() {
    var pwd = document.getElementById("pwd");
    var cpwd = document.getElementById("cpwd");
    if (pwd.type === "password") {
      pwd.type = "text";
      cpwd.type = "text";
    } else {
      pwd.type = "password";
      cpwd.type = "password";
    }
}