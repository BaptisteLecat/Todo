function achieveTask(element) {
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      var task = this.response;
      console.log(task);
      element.parentNode.innerHTML = taskDisplayer(task);

      $(".task_container").each(function () {
        this.addEventListener("touchstart", swipeEditTouchStart, false);
        this.addEventListener("touchmove", swipeEditTouchMove, false);
        this.addEventListener("touchstart", archivePressTouchStart, false);
        this.addEventListener("touchend", archivePressTouchEnd, false);
      });
    } else if (this.readyState == 4) {
      alert("Une erreur est survenue..");
    } else if (this.statusText == "parsererror") {
      alert("Erreur Json");
    }
  };

  xhr.open("POST", "module/task/achieve/achieve.php", true);
  xhr.responseType = "json";
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send(
    "idTask=" +
      element.getAttribute("name") +
      "&idTodo=" +
      encodeURI(document.getElementById("todoName").getAttribute("name"))
  );
}
