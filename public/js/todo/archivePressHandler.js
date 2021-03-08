var onlongtouch;
var selectedElement;
var timer;
var touchduration = 400; //length of time we want the user to touch before we do something

function archivePressTouchStart() {
    selectedElement = this;
    timer = setTimeout(onlongtouch, touchduration);
}

function archivePressTouchEnd() {
    //stops short touches from firing the event
    if (timer) {
        clearTimeout(timer); // clearTimeout, not cleartimeout..
    }
}

onlongtouch = function() {
    var isFinded = false;
    var findedIndex;
    archiveTaskId.forEach(idTask => {
        if (idTask == selectedElement.getAttribute("name")) {
            findedIndex = archiveTaskId.indexOf(idTask);
            isFinded = true;
        }
    });

    if (isFinded) {
        //On le déselectionne
        selectedElement.style.border = "none";
        archiveTaskId.splice(findedIndex, 1);
        console.table(archiveTaskId);
    } else {
        selectedElement.style.border = "2px solid #f25f5c";
        archiveTaskId.push(selectedElement.getAttribute("name"));
    }
}