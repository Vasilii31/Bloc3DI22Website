function password_test_regex(stringToCheck)
{
    const passRegex = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/;
    return(test_regex(stringToCheck, passRegex));
}

function name_test_regex(stringToCheck)
{
    //on accepte uniquement lettres majuscules et minuscule
    //et - é è
    var inputRegex = /^[A-Za-z-éè]+$/;
    return(test_regex(stringToCheck, inputRegex));
}

function username_test_regex(stringToCheck)
{
    //on doit avoir au moins une lettre, on accepte les chiffres et uniquement les - _ ou . comme caractères spéciaux 
    var inputRegex = /^[a-zA-Z][a-zA-Z\d\-_\.]*$|^[a-zA-Z\d\-_\.]*[a-zA-Z]$/
    return(test_regex(stringToCheck, inputRegex));
}

function phone_test_regex(stringToCheck)
{
    var phoneRGEX = /^[(]{0,1}[0-9]{3}[)]{0,1}[-\s\.]{0,1}[0-9]{3}[-\s\.]{0,1}[0-9]{4}$/;
    return(test_regex(stringToCheck, phoneRGEX));
}

function mail_test_regex(stringToCheck)
{
    const mailRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    return(test_regex(stringToCheck, mailRegex));
}

function num_maillot_test_regex(stringToCheck)
{
    const numMaillotRegex = /^[(][1-9]|1[0-9]|20[)]$/;
    return(test_regex(stringToCheck, numMaillotRegex));
}

function test_regex(stringToCheck, regex)
{
    return(regex.test(stringToCheck));
}

//protection contre l'injection de script mais probablement incorrecte
function script_protection(str)
{
    if(str.includes("<script>") || str.includes(";"))
        return false;
    return true;
}