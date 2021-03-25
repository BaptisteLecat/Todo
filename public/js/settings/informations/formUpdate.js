form_isModified = false;

document.getElementsByTagName("form")[0].addEventListener("input", function 
(event) {
    if(!form_isModified){
        form_isModified = true;
        console.log(event.target);
        showSubmitButton(event.target.parentNode.getElementsByClassName("formSubmit")[0]);
    }
});

document.getElementsByClassName("formSubmit")[0].getElementsByTagName("button")[0].addEventListener("click", function(event) {
    hideSubmitButton(event.target.parentNode.getElementsByClassName("formSubmit")[0]);
})

function hideSubmitButton(button) {
    button.style.display = "none";
    button.style.height = "0px";
}


function showSubmitButton(button) {
    button.style.display = "flex";
    button.style.height = "auto";
}