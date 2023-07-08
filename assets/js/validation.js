function displayError(errorMessage, parentContainer, duration = 3000, isSuccess = false) 
{
    const errorText = document.createElement("span");

    if ( isSuccess )
    {
        errorText.setAttribute("class", "error-msg text-success");
    }
    else
    {
        errorText.setAttribute("class", "error-msg text-error");
    }

    errorText.innerHTML = errorMessage;

    parentContainer.appendChild(errorText);



    if ( duration != 0 )
    {

        setTimeout(() => {
            parentContainer.removeChild(errorText);
        }, duration);

    }


    return true;
}

document.querySelector("#togglePassword").addEventListener('click', ()=>{

    const form = document.querySelector(".ui-form");

    const passwordInput = form.querySelector('#password');
    const confirmPasswordInput = form.querySelector('#confirm-password');

    const currentType = passwordInput.getAttribute('type');

    passwordInput.setAttribute('type', currentType === 'password' ? 'text' : 'password');
    confirmPasswordInput.setAttribute('type', currentType === 'password' ? 'text' : 'password');

    if ( currentType === 'password' )
    {
        document.querySelector("#togglePassword").innerHTML = '<i class="fas fa-eye-slash"></i>';
    }
    else if ( currentType === 'text' )
    {
        document.querySelector("#togglePassword").innerHTML = '<i class="fas fa-eye"></i>';
    }
    else
    {
        document.querySelector("#togglePassword").innerHTML = '<i class="fas fa-eye"></i>';
    }

});