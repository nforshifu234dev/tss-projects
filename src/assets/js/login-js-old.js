const form = document.getElementById("loginForm");


function validateFields() 
{
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

form.addEventListener("submit", (event)=>{
    event.preventDefault();



    if ( validateFields() )
    {
        form.querySelector("#password").value = btoa(form.querySelector("#password").value);

        // console.log(true);
        submitForm();
    }


});

// form.querySelector("#submitBtn").addEventListener('click', (event)=>{
//     event.preventDefault();
       
//     if( validateFields() )
//     {

//         submitForm();

//     }
    
// });

function submitForm() 
{

    form.submit();
    
}