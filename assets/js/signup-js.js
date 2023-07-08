const form = document.getElementById("signup-form");
const nextBtns = document.querySelectorAll(".next-btn");
const prevBtns = document.querySelectorAll(".prev-btn");

// Function to check if an email is valid
function isEmailValid(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Function to check if a string contains only integers
function containsOnlyIntegers(str) {
    return /^\d+$/.test(str);
}

// Function to generate a strong password
function generateStrongPassword() {
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

// Function to check if a password is strong
function isPasswordStrong(password) {
    let passwordFeild = document.querySelector("#password");
    let passwordFeildParent = passwordFeild.parentNode;

    const minLength = 8;
    const maxLength = 16;

    if (password.length < minLength || password.length > maxLength) {
        displayError("Make sure the length of your password ranges from 8 - 16 characters", passwordFeildParent);
        return false;
    }

    // Check if the password meets the strong criteria
    const uppercaseRegex = /[A-Z]/;
    const symbolRegex = /[!@#$%^&*()]/;
    const lowercaseRegex = /[a-z]/;
    const numbersRegex = /[0-9]/;

    if (!uppercaseRegex.test(password)) {
        displayError("Your password needs to have at least 1 uppercase(A-Z)", passwordFeildParent);
        return false;
    }

    // if (!symbolRegex.test(password)) {
    //     displayError("Your password needs to have one symbol e.g (!@#$%^&*())", passwordFeildParent);
    //     return false;
    // }

    if (!lowercaseRegex.test(password)) {
        displayError("Your password needs to have at least one lowercase(a-z)", passwordFeildParent);
        return false;
    }

    if (!numbersRegex.test(password)) {
        displayError("Your password needs to have at least one number(0-9)", passwordFeildParent);
        return false;
    }

    return true;
}

function validateFields(step) {

    const fields = step.querySelectorAll("input, textarea, select");

    for (let i = 0; i < fields.length; i++) {
        const field = fields[i];

        if (field.value.trim() === "") {
            // Handle empty fields
            field.classList.add("error-field");

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

    if (stepNumber === 1) {
        // Validation for step 1
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

        if (!isEmailValid(emailFieldValue)) {
            fieldParentContainer.appendChild(errorText);

            setTimeout(() => {
                fieldParentContainer.removeChild(errorText);
            }, 3500);

            return false;
        }

        fieldParentContainer = phoneNumberField.parentNode;

        if (!containsOnlyIntegers(phoneNumberFieldValue)) {
            displayError('Your number should only contain numbers.', fieldParentContainer, 3000);
            return false;
        } 

    }

    if (stepNumber === 4) {
        // Validation for step 4
        const password = step.querySelector("#password");
        const confirm_password = step.querySelector("#confirm-password");

        let passwordParent = password.parentNode;
        let confirm_password_parent = confirm_password.parentNode;

        if (!isPasswordStrong(password.value)) {
            // Handle weak password
            return false;
        }

        if (password.value != confirm_password.value) {
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

        if (validateFields(currentStep)) {
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

reasonForJoiningTextarea.addEventListener('input', function() {
    const textLength = reasonForJoiningTextarea.value.length - 1;
    const remainingCharacters = MAX_CHARACTERS - textLength;

    reasonForJoiningCounter.textContent = textLength + '/' + MAX_CHARACTERS;

    const parentDiv = reasonForJoiningTextarea.parentNode;
    const parentParentDiv = parentDiv.parentNode;
    const btn = parentParentDiv.querySelector('#next-btn3');

    if (textLength >= MAX_CHARACTERS) {
        // Limit the textarea to the maximum number of characters
        reasonForJoiningTextarea.value = reasonForJoiningTextarea.value.slice(0, MAX_CHARACTERS);
        btn.disabled = false;
        reasonForJoiningCounter.classList.remove("text-error");
    } else if (textLength >= 200) {
        // Enable the button when the minimum character limit is reached
        btn.disabled = false;
        reasonForJoiningCounter.classList.remove("text-error");
    } else {
        // Display error and disable button if character limit is not met
        reasonForJoiningCounter.classList.add("text-error");
        btn.addEventListener('click', () => {
            displayError('Write at least 200 characters before proceeding.🙂', parentDiv);
        });
        btn.disabled = true;
    }
});

document.querySelector("#generatePassword").addEventListener('click', () => {
    // Generate a strong password and fill the password fields
    let password = generateStrongPassword();
    const form = document.querySelector(".ui-form");
    form.querySelector('#password').value = password;
    form.querySelector('#confirm-password').value = password;
});


const inputField = document.getElementById('username');
let typingTimer;

inputField.addEventListener('input', function() {
    clearTimeout(typingTimer);
    typingTimer = setTimeout(function() {
        document.querySelector("#username-check").classList.remove('display-none');
        const username = inputField.value;
        let parentDiv = inputField.parentNode;

        if (username === "") {
            displayError("Username is not available", parentDiv);
            document.querySelector("#username-check").innerHTML = '<svg  height="800px" width="800px" version="1.1" id="Capa_1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink"  viewBox="0 0 380 380" xml:space="preserve"> <path fill="rgb(242, 60, 60)" d="M190.001,0C85.233,0,0.001,85.233,0.001,190s85.231,190,189.999,190c104.767,0,189.998-85.233,189.998-190 S294.767,0,190.001,0z M190.001,64.225c23.047,0,44.662,6.237,63.258,17.103l-171.93,171.93 C70.462,234.663,64.225,213.047,64.225,190C64.225,120.647,120.649,64.225,190.001,64.225z M190.001,315.775 c-23.048,0-44.662-6.237-63.258-17.103l171.93-171.93c10.866,18.596,17.103,40.211,17.103,63.258 C315.776,259.353,259.352,315.775,190.001,315.775z"/></svg> ';
        }

        fetch('assets/php/ajax/username-check.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ username: username })
        })
        .then(response => response.json())
        .then(response => {
            if (response.exists === false) {
                displayError("Username is available", parentDiv, 3000, true);
                document.querySelector("#username-check").innerHTML = '<svg width="800px" height="800px" viewBox="0 0 20 20" xmlns="https://www.w3.org/2000/svg" fill="none"><path fill="lightgreen"  fill-rule="evenodd" d="M3 10a7 7 0 019.307-6.611 1 1 0 00.658-1.889 9 9 0 105.98 7.501 1 1 0 00-1.988.22A7 7 0 113 10zm14.75-5.338a1 1 0 00-1.5-1.324l-6.435 7.28-3.183-2.593a1 1 0 00-1.264 1.55l3.929 3.2a1 1 0 001.38-.113l7.072-8z"/></svg>';
            } else {
                displayError("Username is not available", parentDiv);
                document.querySelector("#username-check").innerHTML = '<svg  height="800px" width="800px" version="1.1" id="Capa_1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink"  viewBox="0 0 380 380" xml:space="preserve"> <path fill="rgb(242, 60, 60)" d="M190.001,0C85.233,0,0.001,85.233,0.001,190s85.231,190,189.999,190c104.767,0,189.998-85.233,189.998-190 S294.767,0,190.001,0z M190.001,64.225c23.047,0,44.662,6.237,63.258,17.103l-171.93,171.93 C70.462,234.663,64.225,213.047,64.225,190C64.225,120.647,120.649,64.225,190.001,64.225z M190.001,315.775 c-23.048,0-44.662-6.237-63.258-17.103l171.93-171.93c10.866,18.596,17.103,40.211,17.103,63.258 C315.776,259.353,259.352,315.775,190.001,315.775z"/></svg> ';
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }, 1000);
});

function validateForm() {
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

    if (!t_n_c.checked) {
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
if (error_message_container) {
    error_message_container.querySelector(".close-btn").addEventListener('click', () => {
        const parent = error_message_container.parentNode;
        parent.removeChild(error_message_container);
    });
}




// Get all country codes and their country names and the length of their numbers
function getCountryCodeAndCountryNameAndCallCode() {
    fetch('https://restcountries.com/v2/all')
        .then(response => response.json())
        .then(data => {
            const selectDiv = document.querySelector("#country-code");
            selectDiv.innerHTML = ' ';
            selectDiv.innerHTML = ' <option value="">Select Your Country Code</option>';
    
            data.forEach(country => {
                const countryCode = country.alpha2Code;
                const countryName = country.name;
                const callingCodes = country.callingCodes;
    
                const optionContainer = document.createElement("option");
                optionContainer.setAttribute("value", countryCode);
                optionContainer.innerHTML = ` ${countryName} (${countryCode}) - (+${callingCodes}) `;
    
                selectDiv.append(optionContainer);
            });
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

// Fetch and log the programming stacks
function fetchProgrammingStacks() {

    const selectDiv = document.querySelector("#stack");
    
    selectDiv.innerHTML = ' ';
    selectDiv.innerHTML = ' <option value="">Select Your Role In Tech</option>';

    fetch("assets/json/programming-stacks.json")
    .then(response => response.json())
    .then(data => {
        data.forEach(stack => {
    
            const role = stack.role;
            const shortCode = stack.shortCode;
    
 
    
            const optionContainer = document.createElement("option");
            optionContainer.setAttribute("value", shortCode);
            optionContainer.innerHTML = role;
    
            selectDiv.appendChild(optionContainer);
        });
    })
    .catch(error => {
        console.error("Error fetching programming-stacks.json:", error);
    });
}

// Fetch and log the referral options
function fetchRefferOptions() {

    const selectDiv = document.querySelector("#how-did-you-hear-about-us");
    
    selectDiv.innerHTML = ' ';
    selectDiv.innerHTML = ' <option value="">How did you hear about us:)</option>';

    fetch("assets/json/refers.json")
    .then(response => response.json())
    .then(data => {
        data.forEach(stack => {
            const role = stack.name;
            const shortCode = stack.shortCode;
    

    
            const optionContainer = document.createElement("option");
            optionContainer.setAttribute("value", shortCode);
            optionContainer.innerHTML = role;
    
            selectDiv.append(optionContainer);
        });
    })
    .catch(error => {
        console.error("Error fetching refers.json:", error);
    });
}

// Run the functions when the DOM content is loaded
document.addEventListener('DOMContentLoaded', () => {
    getCountryCodeAndCountryNameAndCallCode();
    fetchProgrammingStacks();
    fetchRefferOptions();
});
