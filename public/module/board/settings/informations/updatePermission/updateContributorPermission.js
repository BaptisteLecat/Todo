function updateContributorPermission(idPermission, idContributor, value) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var response = this.response;
            //console.log(response["todo"]);
            if (response["success"] != null) {
                deleteMessageBox();
                document.getElementsByTagName("body")[0].innerHTML +=
                    response["success"];
                showMessageBox();
            } else {
                if (response["messageBox"] != null) {
                    deleteMessageBox();
                    document.getElementsByTagName("body")[0].innerHTML +=
                        response["messageBox"];
                    showMessageBox();
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