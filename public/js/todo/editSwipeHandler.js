var xDown = null;
var yDown = null;
var isSwiped = false;
var isClickable = true;

function getTouches(evt) {
  return (
    evt.touches || // browser API
    evt.originalEvent.touches
  ); // jQuery
}

function swipeEditTouchStart(evt) {
  if (!isArchived) {
    const firstTouch = getTouches(evt)[0];
    xDown = firstTouch.clientX;
    yDown = firstTouch.clientY;
  }
}

function swipeEditTouchMove(evt) {
  if (!isArchived) {
    if (!xDown || !yDown) {
      return;
    }

    isSwiped = true;
    isClickable = false;

    var xUp = evt.touches[0].clientX;
    var yUp = evt.touches[0].clientY;

    var xDiff = xDown - xUp;
    var yDiff = yDown - yUp;

    if (Math.abs(xDiff) > Math.abs(yDiff)) {
      /*most significant*/
      if (xDiff > 0) {
        /* left swipe */
        $(".task_container").each(function () {
          $(this).removeClass("retract");
        });
        $(this).toggleClass("retract");
        setTimeout(() => {
          isClickable = true;
        }, 1000);
      } else {
        /* right swipe */
        $(this).removeClass("retract");
        isSwiped = false;
      }
    } else {
      if (yDiff > 0) {
        /* up swipe */
      } else {
        /* down swipe */
      }
    }
    /* reset values */
    xDown = null;
    yDown = null;
  }
}
