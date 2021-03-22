function archiveTask() {
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      var response = this.response;

      if (response["success"] != null) {
        archiveTaskId.forEach((idTask) => {
          element = null;
          Array.from(document.getElementsByClassName("task_container")).forEach(
            (task) => {
              console.log(task.getAttribute("name"));
              console.log(archiveTaskId);
              if (task.getAttribute("name") == idTask) {
                element = task;
                return true;
              }
            }
          );
          if (element != null) {
            document
              .getElementsByClassName("task_wrapper")[0]
              .removeChild(element.parentNode);
              console.log(element);
          }
        });
        deleteMessageBox();
        document.getElementsByTagName("body")[0].innerHTML +=
          response["success"];
        showMessageBox();
      } else {
        if (response["messageBox"] != null) {
          deleteMessageBox();
          document.getElementsByTagName("body")[0].innerHTML +=
            response["messageBox"];
          showMessageBox();
        }
      }

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

  xhr.open("POST", "module/task/archive/archive.php", true);
  xhr.responseType = "json";
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send(
    "list_idTask=" +
      JSON.stringify(archiveTaskId) +
      "&idTodo=" +
      encodeURI(document.getElementById("todoName").getAttribute("name"))
  );
}
