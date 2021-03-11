/*
This file manage the achieve and archieve handler.
If the press duration is lower than the touchduration value, the user want to click.
Else the user want to holdclick.
*/
var selectedElement;
var timer;
var startTimeMS = 0;
var touchduration = 400; //length of time we want the user to touch before we do something
var isArchived = false;

function archivePressTouchStart() {
  selectedElement = this;
  startTimeMS = new Date().getTime();
  timer = setTimeout(archiveFunction, touchduration);
}

function archivePressTouchEnd() {
  //stops short touches from firing the event
  if (timer) {
    //Simple click
    if (getRemainingTime() < touchduration) {
      //call achieveTaskFunction
      if (isClickable && isArchived == false) {
        achieveTask(selectedElement);
      }
    }
    clearTimeout(timer); // clearTimeout, not cleartimeout..
  }
}

// Gets the number of ms remaining to execute the event Function
function getRemainingTime() {
  return new Date().getTime() - startTimeMS;
}

function archiveFunction() {
    isArchived ? (isArchived = false) : isArchived = true;
  if (!isSwiped) {
    $(selectedElement).removeClass("retract");
    var isFinded = false;
    var findedIndex;
    archiveTaskId.forEach((idTask) => {
      if (idTask == selectedElement.getAttribute("name")) {
        findedIndex = archiveTaskId.indexOf(idTask);
        isFinded = true;
      }
    });

    if (isFinded) {
      //On le déselectionne
      selectedElement.style.border = "none";
      archiveTaskId.splice(findedIndex, 1);
    } else {
      selectedElement.style.border = "2px solid #f25f5c";
      archiveTaskId.push(selectedElement.getAttribute("name"));
    }
  } else {
    isSwiped = false;
    isClickable = true;
    timer = null;
  }
}
