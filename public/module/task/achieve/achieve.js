function achieveTask(element) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var res = this.response;
            console.log(res);

        } else if (this.readyState == 4) {
            alert("Une erreur est survenue..");
        } else if (this.statusText == "parsererror") {
            alert("Erreur Json");
        }
    };

    xhr.open("POST", "module/task/achieve/achieve.php", true);
    xhr.responseType = "json";
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("idTask=" + element.getAttribute("name") + "&idTodo=" + encodeURI(document.getElementById("todoName").getAttribute("name")));
}