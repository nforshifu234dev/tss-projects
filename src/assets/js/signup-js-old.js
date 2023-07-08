const form = document.getElementById("signup-form");
const nextBtns = document.querySelectorAll(".next-btn");
const prevBtns = document.querySelectorAll(".prev-btn");

function isEmailValid(email) 
{
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function containsOnlyIntegers(str) 
{
    return /^\d+$/.test(str);
}

function generateStrongPassword() 
{

    const minLength = 8;
    const maxLength = 16;
    const uppercaseLetters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    const lowercaseLetters = "abcdefghijklmnopqrstuvwxyz";
    const numbers = "0123456789";
    const symbols = "!@#$%^&*()";
    let password = "";

    const randomLength = Math.floor(Math.random() * (maxLength - minLength + 1)) + minLength;

    // Add at least 1 uppercase letter
    password += uppercaseLetters[Math.floor(Math.random() * uppercaseLetters.length)];

    // Add at least 1 symbol
    password += symbols[Math.floor(Math.random() * symbols.length)];

    // Add at least 1 number
    password += numbers[Math.floor(Math.random() * numbers.length)];

    // Add remaining characters
    for (let i = 3; i < randomLength; i++) {
        const randomCharType = Math.floor(Math.random() * 4);
        if (randomCharType === 0) {
        password += uppercaseLetters[Math.floor(Math.random() * uppercaseLetters.length)];
        } else if (randomCharType === 1) {
        password += lowercaseLetters[Math.floor(Math.random() * lowercaseLetters.length)];
        } else if (randomCharType === 2) {
        password += symbols[Math.floor(Math.random() * symbols.length)];
        } else {
        password += numbers[Math.floor(Math.random() * numbers.length)];
        }
    }

    return password;

}


function isPasswordStrong(password) 
{

    let passwordFeild = document.querySelector("#password");
    let passwordFeildParent = passwordFeild.parentNode;


    const minLength = 8;
    const maxLength = 16;

    if (password.length < minLength || password.length > maxLength) 
    {
        displayError("Make sure the length of your password ranges from 8 - 16 characters", passwordFeildParent);
        return false;
    }

    // Check if the password meets the strong criteria
    const uppercaseRegex = /[A-Z]/;
    const symbolRegex = /[!@#$%^&*()]/;
    const lowercaseRegex = /[a-z]/;
    const numbersRegex = /[0-9]/;

    if (
        !uppercaseRegex.test(password) 
    ) {
        displayError("Your password needs to have at least 1 uppercase(A-Z)", passwordFeildParent);
        return false;
    }

    // if (
    //     !symbolRegex.test(password)
    // ) {
    //     displayError("Your password needs to have one symbol e.g (!@#$%^&*())", passwordFeildParent);
    //     return false;
    // }

    if (
        !lowercaseRegex.test(password)
    ) {
        displayError("Your password needs to have at least one lowercase(a-z)", passwordFeildParent);
        return false;
    }

    if (
        !numbersRegex.test(password)
    ) {
        displayError("Your password needs to have at least one number(0-9)", passwordFeildParent);
        return false;
    }



    return true;
}






function validateFields(step) 
{

    const fields = step.querySelectorAll("input, textarea, select");

    for (let i = 0; i < fields.length; i++) 
    {
        const field = fields[i];

        if (field.value.trim() === "") 
        {
            // alert("Please fill in all fields.");
            field.classList.add("error-field");

            // <span class="error-msg text-error">You cannot leave this empty🥲</span>

            const errorText = document.createElement("span"); 
                        errorText.setAttribute("class", "error-msg text-error");
                        errorText.innerHTML = "You cannot leave this empty🥲";

            let fieldParentContainer = field.parentNode;

            fieldParentContainer.appendChild(errorText);                    

            setTimeout(() => {

                fieldParentContainer.removeChild(errorText);
                field.classList.remove("error-field");
                
            }, 3000);

            field.focus();
            return false;
        }



    }

    const stepId = step.getAttribute("id");
    const stepNumber = parseInt(stepId.match(/\d+/)[0]);

    if ( stepNumber === 1 )
    {

        const emailField = step.querySelector('#email');
        const emailFieldValue = emailField.value;

        const phoneNumberField = step.querySelector('#phone-number');
        const phoneNumberFieldValue = phoneNumberField.value;

        const phoneNumberCountryCodeFeild = step.querySelector("#country-code");
        const phoneNumberCountryCodeFeildValue = phoneNumberCountryCodeFeild.value;


        const errorText = document.createElement("span"); 
                        errorText.setAttribute("class", "error-msg text-error");
                        errorText.innerHTML = "Your email is not correct in a correct format. kindly check it out.";

        let fieldParentContainer = emailField.parentNode;


        if ( !isEmailValid(emailFieldValue) )
        {
            fieldParentContainer.appendChild(errorText);       

            setTimeout(() => {
                
                fieldParentContainer.removeChild(errorText);

            }, 3500);

            return false;

        }

        fieldParentContainer = phoneNumberField.parentNode;

        if ( !containsOnlyIntegers(phoneNumberFieldValue) )
        {

            // function displayError(errorMessage, parentContainer, validationCondition, duration) 
            displayError( 'Your number should only contain numbers.', fieldParentContainer, 3000 );

            return false;

        }
        else if ( containsOnlyIntegers(phoneNumberFieldValue) )
        {
            // const url = `http://apilayer.net/api/validate?access_key=65ea7fd611382741ea7b08ea0d35cd52&number=${phoneNumberFieldValue}&country_code=${phoneNumberCountryCodeFeildValue}&format=1`;

            // const xhr = new XMLHttpRequest();

            // xhr.open('GET', url);
            // xhr.responseType = 'json';
            // xhr.send();
            // let isPhoneNumberValid = false;

            // xhr.onload = () => {

            //     if (xhr.status === 200) {
            //     const data = xhr.response;
            //     console.log(data);
        
            //     if (data.valid === false) {
            //         displayError("Your Phone Number is not correct. Please try again.", fieldParentContainer, 4000);
            //         isPhoneNumberValid = false;
            //     } 
            //     else
            //     {
            //         isPhoneNumberValid = true;
            //     }

            //     } else {
            //     displayError("The response was not okay. Try again.", fieldParentContainer, 4000);
            //     }
            // };

            // console.log(isPhoneNumberValid);

            // if (!isPhoneNumberValid) {
            //     // Handle the case where the phone number is not valid
            //     return false;
            // } else {
            // // Handle the case where the phone number is valid
            // }

//             const url = `http://apilayer.net/api/validate?access_key=65ea7fd611382741ea7b08ea0d35cd52&number=${phoneNumberFieldValue}&country_code=${phoneNumberCountryCodeFeildValue}&format=1`;
//             const xhr = new XMLHttpRequest();
//             xhr.open('GET', url);
//             xhr.responseType = 'json';
//             xhr.send();
//             let isPhoneNumberValid = false;

//             xhr.onload = () => {
//             if (xhr.status === 200) {
//                 const data = xhr.response;
//                 console.log(data);

//                 if (data.valid === false) {
//                 displayError("Your Phone Number is not correct. Please try again.", fieldParentContainer, 4000);
//                 isPhoneNumberValid = false;
//                 } else if ( data.valid === true )
//                 {
//                 isPhoneNumberValid = true;
//                 }

//                 handlePhoneNumberValidation(isPhoneNumberValid);



//             } else {
//                 displayError("The response was not okay. Try again.", fieldParentContainer, 4000);
//             }
//             };

// function handlePhoneNumberValidation(isValid) {
//     console.log(isValid);
//   if (isValid) {
//     // Handle the case where the phone number is valid
//     console.log("Phone number is valid");
//   } else {
//     // Handle the case where the phone number is not valid
//     console.log("Phone number is not valid");
//   }
// }

              
              
              
                              // Call a function here that depends on the isPhoneNumberValid value
                            //   setTimeout(() => {
                            //     handlePhoneNumberValidation(isPhoneNumberValid);
                            //   }, 3000);
              
              
              


        }
         

            let phoneNumber = `+${phoneNumberCountryCodeFeildValue}${phoneNumberFieldValue}`;

            // console.log(phoneNumber);

            // console.log(url);

           
            // Usage:
            // function validatePhoneNumber() 
            // {
            
                // const xhr = new XMLHttpRequest();

                // xhr.open('GET', url);
                // xhr.responseType = 'json';
                // xhr.send();

                // const result = xhr.onload = () => {
                //     if (xhr.status === 200) {
                //     const data = xhr.response;
                //     console.log(data);
            
                //     if (data.valid === false) {
                //         displayError("Your Phone Number is not correct. Please try again.", fieldParentContainer, 4000);
                //         return false;
                //     } else {
                //         return true;
                //     }
                //     } else {
                //     displayError("The response was not okay. Try again.", fieldParentContainer, 4000);
                //     }
                // };

                // console.log(result);

                
            // }

            // console.log(validatePhoneNumber());



        

        
        
        
        






    }

    if ( stepNumber === 4 )
    {

        const password = step.querySelector("#password");
        const confirm_password = step.querySelector("#confirm-password");

        let passwordParent = password.parentNode;
        let confirm_password_parent = confirm_password.parentNode;

        if (!isPasswordStrong(password.value)) 
        {
            // console.log("Password is strong!");
            // Proceed with further logic for a strong password
            return false;
        } 


        if ( password.value != confirm_password.value )
        {

            displayError("Passwords don't match", passwordParent);
            displayError("Passwords don't match", confirm_password_parent);
            
            return false;

        }


    }





    return true;

}

nextBtns.forEach((nextBtn, index) => {
    nextBtn.addEventListener("click", (e) => {
        e.preventDefault();
        const currentStep = document.getElementById(`step${index + 1}`);
        const nextStep = document.getElementById(`step${index + 2}`);

        if (validateFields(currentStep)) 
        {
        
            currentStep.style.display = "none";
            nextStep.style.display = "block";

        }


    });
});

prevBtns.forEach((prevBtn, index) => {
    prevBtn.addEventListener("click", (e) => {
        e.preventDefault();
        const currentStep = document.getElementById(`step${index + 2}`);
        const prevStep = document.getElementById(`step${index + 1}`);
        currentStep.style.display = "none";
        prevStep.style.display = "block";
    });
});



const reasonForJoiningTextarea = document.querySelector('#reason');
const reasonForJoiningCounter = document.querySelector('#counter');

const MAX_CHARACTERS = 250;

reasonForJoiningTextarea.addEventListener('input', function() 
{
    const textLength = reasonForJoiningTextarea.value.length - 1;
    const remainingCharacters = MAX_CHARACTERS - textLength;

    reasonForJoiningCounter.textContent = textLength + '/' + MAX_CHARACTERS;


    const parentDiv = reasonForJoiningTextarea.parentNode;

    const parentParentDiv = parentDiv.parentNode;

    const btn = parentParentDiv.querySelector('#next-btn3');

    if (textLength >= MAX_CHARACTERS) 
    {
        reasonForJoiningTextarea.value = reasonForJoiningTextarea.value.slice(0, MAX_CHARACTERS);
        btn.disabled = false;
        reasonForJoiningCounter.classList.remove("text-error");
    }
    else if ( textLength >= 200 )
    {

        btn.disabled = false;
        
        reasonForJoiningCounter.classList.remove("text-error");

    }
    else
    {

        reasonForJoiningCounter.classList.add("text-error");

        
        btn.addEventListener('click', ()=>{
            displayError('Write at least 200 characters before proceeding.🙂', parentDiv);
        } );
        btn.disabled = true;

    }

});


document.querySelector("#generatePassword").addEventListener('click', ()=>{

    let password = generateStrongPassword();

    const form = document.querySelector(".ui-form");

    form.querySelector('#password').value = password;
    form.querySelector('#confirm-password').value = password;



});

document.querySelector("#togglePassword").addEventListener('click', ()=>{

    const form = document.querySelector(".ui-form");

    const passwordInput = form.querySelector('#password');
    const confirmPasswordInput = form.querySelector('#confirm-password');

    const currentType = passwordInput.getAttribute('type');

    passwordInput.setAttribute('type', currentType === 'password' ? 'text' : 'password');
    confirmPasswordInput.setAttribute('type', currentType === 'password' ? 'text' : 'password');
    // togglePassword.classList.toggle('fa-eye-slash');

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



const inputField = document.getElementById('username');
let typingTimer;

inputField.addEventListener('input', function() 
{
    clearTimeout(typingTimer);

    typingTimer = setTimeout(function() {


        document.querySelector("#username-check").classList.remove('display-none');

        const username = inputField.value;
        let parentDiv = inputField.parentNode;

        if ( username === "" )
        {
            displayError("Username is not available", parentDiv);
            document.querySelector("#username-check").innerHTML = '<svg  height="800px" width="800px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"  viewBox="0 0 380 380" xml:space="preserve"> <path fill="rgb(242, 60, 60)" d="M190.001,0C85.233,0,0.001,85.233,0.001,190s85.231,190,189.999,190c104.767,0,189.998-85.233,189.998-190 S294.767,0,190.001,0z M190.001,64.225c23.047,0,44.662,6.237,63.258,17.103l-171.93,171.93 C70.462,234.663,64.225,213.047,64.225,190C64.225,120.647,120.649,64.225,190.001,64.225z M190.001,315.775 c-23.048,0-44.662-6.237-63.258-17.103l171.93-171.93c10.866,18.596,17.103,40.211,17.103,63.258 C315.776,259.353,259.352,315.775,190.001,315.775z"/></svg> ';
        }

        fetch('assets/php/ajax/username-check.php',
        {

            method: 'POST',
            headers: {
            'Content-Type': 'application/json'
            },
            body: JSON.stringify({ username: username })
        })

        .then(response => response.json())

        .then( response => {

            // Check if the response exists and is false
            if (response.exists === false) 
            {
                // Further logic when the response is false

                displayError("Username is available", parentDiv, 3000, true);
                document.querySelector("#username-check").innerHTML = '<svg width="800px" height="800px" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" fill="none"><path fill="lightgreen"  fill-rule="evenodd" d="M3 10a7 7 0 019.307-6.611 1 1 0 00.658-1.889 9 9 0 105.98 7.501 1 1 0 00-1.988.22A7 7 0 113 10zm14.75-5.338a1 1 0 00-1.5-1.324l-6.435 7.28-3.183-2.593a1 1 0 00-1.264 1.55l3.929 3.2a1 1 0 001.38-.113l7.072-8z"/></svg>'; 

            } 
            else 
            {
                // Further logic when the response is true or other values

                displayError("Username is not available", parentDiv);
                document.querySelector("#username-check").innerHTML = '<svg  height="800px" width="800px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"  viewBox="0 0 380 380" xml:space="preserve"> <path fill="rgb(242, 60, 60)" d="M190.001,0C85.233,0,0.001,85.233,0.001,190s85.231,190,189.999,190c104.767,0,189.998-85.233,189.998-190 S294.767,0,190.001,0z M190.001,64.225c23.047,0,44.662,6.237,63.258,17.103l-171.93,171.93 C70.462,234.663,64.225,213.047,64.225,190C64.225,120.647,120.649,64.225,190.001,64.225z M190.001,315.775 c-23.048,0-44.662-6.237-63.258-17.103l171.93-171.93c10.866,18.596,17.103,40.211,17.103,63.258 C315.776,259.353,259.352,315.775,190.001,315.775z"/></svg> ';

            }

        })
        .catch(error => {
            console.error('Error:', error);
        });

    }, 1000);



});

function validateForm() 
{

    const form = document.querySelector(".ui-form");

    const firstname = form.querySelector("#first-name").value;
    const lastname = form.querySelector("#last-name").value;
    const email = form.querySelector("#email").value;
    const phone = form.querySelector("#country-code").value + form.querySelector("#phone-number").value;
    const stack = form.querySelector("#stack").value;
    const how_did_you_hear_about_us = form.querySelector("#how-did-you-hear-about-us").value;
    const reason = form.querySelector("#reason").value;
    const username = form.querySelector("#username").value;

    const t_n_c = form.querySelector("#t-n-c");

    if (! t_n_c.checked) 
    {
        const t_n_c_parent = t_n_c.parentNode;

        displayError("Kindly read the Agreements and click the checkbox to your left to proceed.", t_n_c_parent);

        return false;

    }

    var password = form.querySelector("#password").value;

    password = btoa(password);

    form.querySelector("#password").value = password;

    var confirm_password = form.querySelector("#confirm-password").value;

    confirm_password = btoa(confirm_password);

    form.querySelector("#confirm-password").value = confirm_password;

    console.log(password);
    console.log(confirm_password);



    return true;

}

document.querySelector("#submit").addEventListener('click', (event) => {
        // event.preventDefault();
        
        if (validateForm()) {
            // document.getElementById("signup-form").submit();
            // document.querySelector("form").submit();
        }
});


    const error_message_container = document.querySelector("#error-message-container");
    if (error_message_container) 
    {

        error_message_container.querySelector(".close-btn").addEventListener('click', ()=>{

            const parent = error_message_container.parentNode;
            
            parent.removeChild(error_message_container);

        });

    }





// get all country codes and thier country names and the length of thier numbers

document.addEventListener('DOMContentLoaded', ()=> {

    fetch('https://restcountries.com/v2/all')
    .then(response => response.json())
    .then(data => {
        const selectDiv = document.querySelector("#country-code");

        // const divToPlaceCountries = selectDiv.querySelector(".loadingCountries");
        // console.log(divToPlaceCountries);
        // divToPlaceCountries.innerHTML = "";

        selectDiv.innerHTML = ' ';
        selectDiv.innerHTML = ' <option value="">Select Your Country Code</option>';

      data.forEach(country => {
        const countryCode = country.alpha2Code;
        const countryName = country.name;
        const callingCodes = country.callingCodes;
        
        // console.log(countryCode, countryName, callingCodes);

        const optionContainer = document.createElement("option")
                    optionContainer.setAttribute("value", countryCode);
                    optionContainer.innerHTML = ` ${countryName} (${countryCode}) - (+${callingCodes}) `;




        selectDiv.append(optionContainer);

      });
    })
    .catch(error => {
      console.error('Error:', error);
    });
  


});


document.querySelector("#phone-number").addEventListener('change', ()=>{

    let nextBtn = document.querySelector('#next-btn1');

    nextBtn.disabled = true;

    const phoneNumberField = document.querySelector('#phone-number');
    const phoneNumberFieldValue = phoneNumberField.value;

    const phoneNumberCountryCodeFeild = document.querySelector("#country-code");
    const phoneNumberCountryCodeFeildValue = phoneNumberCountryCodeFeild.value;

    fieldParentContainer = phoneNumberField.parentNode;
    if ( phoneNumberCountryCodeFeildValue === '' || phoneNumberCountryCodeFeildValue === undefined )
    {
        displayError("You need to choose a country code", fieldParentContainer, 3000);
    }
    else {    

        setTimeout(() => {


                
                const url = `http://apilayer.net/api/validate?access_key=65ea7fd611382741ea7b08ea0d35cd52&number=${phoneNumberFieldValue}&country_code=${phoneNumberCountryCodeFeildValue}&format=1`;
                const xhr = new XMLHttpRequest();
                xhr.open('GET', url);
                xhr.responseType = 'json';
                xhr.send();

                xhr.onload = () => {
                if (xhr.status === 200) {
                    const data = xhr.response;

                    if (data.valid === false) 
                    {
                        displayError("Your Phone Number is not correct. Please try again.", fieldParentContainer, 4000);
                    } else if ( data.valid === true )
                    {
                        displayError("Your Phone Number is correct. You can proceed.", fieldParentContainer, 4000, true);
                        nextBtn.disabled = false;
                    }




                } else {
                    displayError("The response was not okay. Try again.", fieldParentContainer, 4000);
                }
                };


        }, 1000);
    }


});

