var day = 0; // -3 to 3. 

function dayBefore() {
    if (day > -3) {
        day--;
        displayTaskByDay();
    } else {
        alert("Limite de jour before atteinte.");
    }
}

function dayNext() {
    if (day < 3) {
        day++;
        displayTaskByDay();
    } else {
        alert("Limite de jour Next atteinte.");
    }
}

function displayTaskByDay() {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var res = this.response;
            console.log(res);

            var html = "";
            document.getElementById("dayTitle").innerText = res["dayTitle"];

            res["listTask"].forEach(task => {
                html = html.concat('<div class="task_container">');
                if (task.active == 1) {
                    html = html.concat(`
                <div class="task_content_validate">
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
                <div class="task_content_todo">
                    <div class="task_title">
                      <h6>${task.content}</h6>
                    </div>
                    <div class="task_todo"></div>
                  </div>
                  <img class="bin_icon" src="../assets/icons/trash_52px.png" alt="bin to delete"></div>`);
                }
            });
            html.concat(`<button type="button" name="AddTask" class="btn_addClass">
            <h1>+</h1>
          </button></div>`);
            document.getElementById('todoContent').innerHTML = html;

        } else if (this.readyState == 4) {
            alert("Une erreur est survenue..");
        } else if (this.statusText == "parsererror") {
            alert("Erreur Json");
        }
    };

    xhr.open("POST", "function/switch_dayDisplayer.php", true);
    xhr.responseType = "json";
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("day=" + encodeURI(day));

    return false;
}