//Cette fonction permet de faire passer le tableau associatif en le séparant en 2 tableau, récupérer en POST.
function generateAJAXURL(form_elements) {
    var stringAttribute = "";
    var stringValue = "";
    Object.keys(form_elements).forEach((element, index) => {
        if (index > 0) {
            stringAttribute += `&form_attributes[]=${element}`;
            stringValue += `&form_values[]=${form_elements[element]}`;
        } else {
            stringAttribute += `form_attributes[]=${element}`;
            stringValue += `&form_values[]=${form_elements[element]}`;
        }
    });
    return stringAttribute + "&" + stringValue;
}

function updateTodoInfo(form, form_elements) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var response = this.response;
            //console.log(response["todo"]);
            if (response["success"] != null) {
                Object.keys(form_elements).forEach((attribute) => {
                    console.log(attribute);
                    form.getElementsByName(attribute)[0].value =
                        response["todo"].attribute;
                });
                createMessageBox(response["success"]);
            } else {
                if (response["messageBox"] != null) {
                    createMessageBox(response["messageBox"]);
                }
            }
        } else if (this.readyState == 4) {
            alert("Une erreur est survenue..");
        } else if (this.statusText == "parsererror") {
            alert("Erreur Json");
        }
    };

    xhr.open(
        "POST",
        "module/board/settings/informations/updateTodoInfo/updateTodoInfo.php",
        true
    );
    xhr.responseType = "json";
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(
        generateAJAXURL(form_elements) +
        "&idTodo=" +
        encodeURI(document.getElementById("todoName").getAttribute("name"))
    );
}