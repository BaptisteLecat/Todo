function archiveButtonManager() {
    if (archiveTaskId.length > 0) {
        document.getElementsByClassName("archive_container")[0].style.height = "30px";
    } else {
        document.getElementsByClassName("archive_container")[0].style.height = "0px";
    }
}

function cancelArchive(){
    archiveTaskId.forEach(taskId => {
        var taskList = document.getElementsByClassName("task_container");
        for (let index = 0; index < taskList.length; index++) {
          if(taskList[index].getAttribute("name") == taskId){
              taskList[index].style.border = "none";
              break;
          }
        }
    });
    archiveTaskId = [];
    isArchived = false;
    archiveButtonManager();
}