function cancelContributeRequest(idTodo) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var response = this.response;
            console.log(response);
            if (response["success"] != null) {
                document.getElementsByClassName(
                    "invitation_wrapper"
                )[0].innerHTML = displayPendingContribute(
                    response["list_pendingContribute"]
                );
                createMessageBox(response["success"]);
            } else {
                if (response["messageBox"] != null) {
                    console.log("cxdf");
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
        "module/social/cancelContributeRequest/cancelContributeRequest.php",
        true
    );
    xhr.responseType = "json";
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("idTodo=" + encodeURI(idTodo)); //day référence a la variable day du script switcherDay.js
}