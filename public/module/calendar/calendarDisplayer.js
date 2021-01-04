var month = 0; //Index du mois.

function monthBefore() {
    if (month > -12) {
        month--;
        DisplayCalendar();
    } else {
        alert("Error index out of range -");
    }
}

function monthNext() {
    if (month < 12) {
        month++;
        DisplayCalendar();
    } else {
        alert("Error index out of range +");
    }
}

function DisplayCalendar() {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var res = this.response;
            console.log(res);

            document.getElementById('calendar_title').innerText = res["calendarMonth"] + " " + res["calendarYear"];
            document.getElementById('calendar_content').innerHTML = res["calendarHTML"];

        } else if (this.readyState == 4) {
            alert("Une erreur est survenue..");
        } else if (this.statusText == "parsererror") {
            alert("Erreur Json");
        }
    };

    xhr.open("POST", "module/calendar/ajax/calendarDisplayer.php", true);
    xhr.responseType = "json";
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("month=" + encodeURI(month));
}