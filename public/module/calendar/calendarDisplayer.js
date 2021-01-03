var month = 0; //Index du mois.

function monthBefore() {
    if (month > -12) {
        month--;
    } else {
       //Error index.
    }
}

function monthNext() {
    if (month < 12) {
        month++;
    } else {
        //Error Index.
    }
}

function DisplayCalendar() {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var res = this.response;
            console.log(res);

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