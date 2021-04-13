function deleteToken(token) {
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
        "module/board/settings/invitations/deleteToken/deleteToken.php",
        true
    );
    xhr.responseType = "json";
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("&token=" + encodeURI(token));
}