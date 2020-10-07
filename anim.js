var monthis = null;

function DisplayInfo(object){
  monthis = object;
  alert(monthis);
}

var mouseIsDown = false;

if (monthis != null) {

  monthis.addEventListener('mousedown', function() {
    mouseIsDown = true;
    setTimeout(function() {
      if(mouseIsDown) {
        monthis.style.height = "90px";
      }
    }, 700);
  });

  monthis.addEventListener('mouseup', function() {
    mouseIsDown = false;
  });

}
