function switchDay(dayIndex) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var response = this.response;
            if (response["messageBox"] != null) {
                createMessageBox(response["messageBox"]);
            } else {
                document.getElementsByClassName(
                    "todo_content"
                )[0].innerHTML = displayTask(
                    response["taskForToday"],
                    response["taskPourcentToday"],
                    response["globalTaskPourcent"],
                    response["dateSet"]
                );
                createMessageBox(response["success"]);
            }
        } else if (this.readyState == 4) {
            alert("Une erreur est survenue..");
        } else if (this.statusText == "parsererror") {
            alert("Erreur Json");
        }
    };

    xhr.open("POST", "module/home/taskDisplayer/switchDay/switchDay.php", true);
    xhr.responseType = "json";
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("dayIndex=" + encodeURI(dayIndex));
}