var day = 0; // -3 to 3. 

function dayBefore() {
    if (day > -3) {
        day--;
        document.getElementById('nextSwitcher').style.opacity = 1;
        displayTaskByDay();
    } else {
        document.getElementById('previousSwitcher').style.opacity = 0.5;
    }
}

function dayNext() {
    if (day < 3) {
        day++;
        document.getElementById('previousSwitcher').style.opacity = 1;
        displayTaskByDay();
    } else {
        document.getElementById('nextSwitcher').style.opacity = 0.5;
    }
}

function displayTaskByDay() {
    var nbActiveTask = 0;
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var res = this.response;
            console.log(res);

            var html = "";
            document.getElementById("dayTitle").innerText = res["dayTitle"];
            document.getElementById("dateValue").innerText = res["dateString"];
            res["listTask"].forEach(task => {
                html = html.concat(`<div class="task_container" id="${task.id}">`);
                if (task.active == 1) {
                    nbActiveTask++;
                    html = html.concat(`
                <div class="task_content_validate" onclick="activeModifier(this)">
                    <div class="task_title">
                        <h6>${task.content}</h6>
                    </div>
                    <div class="task_validate">
                        <img class="validate_icon" src="../assets/icons/checkmark_52px.png" alt="validate icon">
                    </div>
                  </div>
                  <img class="bin_icon" src="../assets/icons/trash_52px.png" alt="bin to delete"></div>`);
                } else {
                    html = html.concat(`
                <div class="task_content_todo" id="${task.id}" onclick="activeModifier(this)">
                    <div class="task_title">
                      <h6>${task.content}</h6>
                    </div>
                    <div class="task_todo"></div>
                  </div>
                  <img class="bin_icon" src="../assets/icons/trash_52px.png" alt="bin to delete" onclick="deleteTask(this)"></div>`);
                }
            });
            
            document.getElementById('todoContent').innerHTML = html;
            document.getElementById('progressState').innerHTML = nbActiveTask + "/" + res["listTask"].length;
            if(res["listTask"].length > 0){
                document.getElementById('progressValue').style.width = (nbActiveTask / res["listTask"].length)*100 + "%";
            }else{
                document.getElementById('progressValue').style.width = "0%";
            }

        } else if (this.readyState == 4) {
            alert("Une erreur est survenue..");
        } else if (this.statusText == "parsererror") {
            alert("Erreur Json");
        }
    };

    xhr.open("POST", "module/taskDisplayer/ajax/dayDisplayer.php", true);
    xhr.responseType = "json";
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("day=" + encodeURI(day));
}

function activeModifier(object){
    var idTask = object.parentNode.id;
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var res = this.response;
            console.log(res);
            displayTaskByDay();

        } else if (this.readyState == 4) {
            alert("Une erreur est survenue..");
        } else if (this.statusText == "parsererror") {
            alert("Erreur Json");
        }
    };

    xhr.open("POST", "module/taskDisplayer/ajax/activeModifier.php", true);
    xhr.responseType = "json";
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("idTask=" + encodeURI(idTask));
}

function deleteTask(object){
    var idTask = object.parentNode.id;
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var res = this.response;
            console.log(res);
            displayTaskByDay();

        } else if (this.readyState == 4) {
            alert("Une erreur est survenue..");
        } else if (this.statusText == "parsererror") {
            alert("Erreur Json");
        }
    };

    xhr.open("POST", "module/taskDisplayer/ajax/delete.php", true);
    xhr.responseType = "json";
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("idTask=" + encodeURI(idTask));
}