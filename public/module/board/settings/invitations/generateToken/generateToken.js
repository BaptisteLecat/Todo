function generateToken() {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var response = this.response;
            if (response["success"] != null) {
                document.getElementsByClassName(
                    "token_wrapper"
                )[0].innerHTML = displayToken(response["list_token"]);
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
        "module/board/settings/invitations/generateToken/generateToken.php",
        true
    );
    xhr.responseType = "json";
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(
        "&idTodo=" +
        encodeURI(document.getElementById("todoName").value)
    );
}


function displayToken(list_token) {
    html = "";
    list_token.forEach(token => {
        html = html.concat(`<div class="token_container">
                        <div class="token_content">
                            <h6>${token.token}</h6>
                            <p>${token.expirationDate}</p>
                        </div>
                        <div class="token_button">
                            <img src="..\\..\\assets\\icons\\refresh.png" alt="">
                            <img src="..\\\..\\assets\\icons\\trash.png" alt="">
                        </div>
                    </div>`);
    });

    return html;
}