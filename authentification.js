const displayform = pE('displayForm');
const forLogin = pE('forLogin');
const loginForm = pE('loginForm');
const forRegister = pE('forRegister');
const registerForm = pE('registerForm');
const formContainer = pE('formContainer');
const registerButton = pE('registerButton');
displayform.addEventListener('click', showForm);

//registerButton.addEventListener('click', GlobalVerif);

function pE(e)
{
    return document.getElementById(e);
}

function showForm()
{
    document.querySelector('.form-wrapper .card').classList.toggle('show');
}

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