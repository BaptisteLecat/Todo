var day = 0; // -3 to 3.

function dayBefore() {
    if (day <= -3) {
        document.getElementById("previousSwitcher").style.opacity = 0.5;
    } else {
        day--;
        document.getElementById("nextSwitcher").style.opacity = 1;
        switchDay(day);
        if (day <= -3) {
            document.getElementById("previousSwitcher").style.opacity = 0.5;
        }
    }
}

function dayNext() {
    if (day >= 3) {
        document.getElementById("nextSwitcher").style.opacity = 0.5;
    } else {
        day++;
        document.getElementById("previousSwitcher").style.opacity = 1;
        switchDay(day);
        if (day >= 3) {
            document.getElementById("nextSwitcher").style.opacity = 0.5;
        }
    }
}