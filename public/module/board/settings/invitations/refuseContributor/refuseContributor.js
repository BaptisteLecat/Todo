function refuseContributor(idContributor, idTodo) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var response = this.response;
            if (response["success"] != null) {
                document.getElementsByClassName(
                    "invitation_wrapper"
                )[0].innerHTML = displayInvitations(response["list_invitation"], idTodo);
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
        "module/board/settings/invitations/refuseContributor/refuseContributor.php",
        true
    );
    xhr.responseType = "json";
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(
        "&idContributor=" +
        encodeURI(idContributor) +
        "&idTodo=" +
        encodeURI(idTodo)
    );
}