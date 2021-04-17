function achieveTask(idTask) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var response = this.response;
            if (response["success"] != null) {
                document.getElementsByClassName(
                    "todo_content"
                )[0].innerHTML = displayTask(
                    response["list_task"],
                    response["taskPourcent"]
                );
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

    xhr.open("POST", "module/home/taskDisplayer/achieveTask/achieveTask.php", true);
    xhr.responseType = "json";
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("idTask=" + encodeURI(idTask));
}