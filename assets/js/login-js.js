
const form = document.getElementById("loginForm");

// Function to validate the input fields
function validateFields() {
    let isValid = true;
    const allInputs = form.querySelectorAll("input");

    allInputs.forEach((input) => {
        if (input.value === "") {
            let fieldParentContainer = input.parentNode;
            displayError("This field is required ⚠️", fieldParentContainer);
            input.focus();
            isValid = false;
        }
    });

    return isValid;
}

// Event listener for form submission
form.addEventListener("submit", (event) => {
    event.preventDefault();

    // Validate the fields before submitting the form
    if (validateFields()) {
        form.querySelector("#password").value = btoa(form.querySelector("#password").value);

        // Submit the form
        submitForm();
    }
});

// Function to submit the form
function submitForm() {
    form.submit();
}
