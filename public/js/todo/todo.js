var archiveTaskId = [];

//Chargement des evenements sur les task_container
$(".task_container").each(function () {
  this.addEventListener("touchstart", swipeEditTouchStart, false);
  this.addEventListener("touchmove", swipeEditTouchMove, false);
  this.addEventListener("touchstart", archivePressTouchStart, false);
  this.addEventListener("touchend", archivePressTouchEnd, false);
});
