function updateContributorPermission(idPermission, idContributor, value, contributorBox) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var response = this.response;
            if (response["success"] != null) {
                if (response["contributorObject"].permission.length <= 0) {
                    contributorBox.remove();
                }
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
        "module/board/settings/informations/updatePermission/updateContributorPermission.php",
        true
    );
    xhr.responseType = "json";
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(
        "idContributor=" +
        idContributor +
        "&idPermission=" +
        idPermission +
        "&value=" +
        value +
        "&idTodo=" +
        encodeURI(document.getElementById("todoName").getAttribute("name"))
    );
}