form_isModified = false;

document
    .getElementsByTagName("form")[0]
    .addEventListener("input", function(event) {
        if (!form_isModified) {
            form_isModified = true;
            console.log(event.target);
            showSubmitButton(
                event.target.parentNode.getElementsByClassName("formSubmit")[0]
            );
        }
    });

document
    .getElementsByClassName("formSubmit")[0]
    .getElementsByTagName("button")[0]
    .addEventListener("click", function(event) {
        submitForm(event.target.parentNode.parentNode);
        hideSubmitButton(event.target);
    });

function submitForm(form) {
    form_elements = [];
    //Creation d'un tableau associatif nomInput => valeur.
    Array.from(form.getElementsByTagName("input")).forEach((input) => {
        if (input.type != "hidden") {
            form_elements[input.getAttribute("name")] = input.value;
        }
    });

    Array.from(form.getElementsByTagName("textarea")).forEach((textarea) => {
        form_elements[textarea.getAttribute("name")] = textarea.value;
    });

    //Appel à la fonction de update dans la base en AJAX
    updateTodoInfo(form, form_elements);
}

function hideSubmitButton(button) {
    button.style.display = "none";
    button.style.maxHeight = "0px";
}

function showSubmitButton(button) {
    button.style.display = "flex";
    button.style.maxHeight = "600px";
}