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