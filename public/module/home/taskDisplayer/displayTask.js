function displayTask(
    list_task,
    taskPourcent,
    globalTaskPourcent,
    dateSet = null
) {
    html = "";
    nbTaskAchieve = 0;
    list_task.forEach((task) => {
        html = html.concat(`<div class="task_container" id="${task.id}">`);
        if (task.isAchieve) {
            nbTaskAchieve++;
            html = html.concat(`<div class="task_content_validate" id="${task.id}" onclick="achieveTask(${task.id})">
            <div class="task_title">
              <h6>${task.title}</h6>
            </div>
            <div class="task_validate">
              <img class="validate_icon" src="..\\assets\\icons\\checkmark_52px.png" alt="validate icon">
            </div>
          </div>`);
        } else {
            html = html.concat(`<div class="task_content_todo" id="${task.id}" onclick="achieveTask(${task.id})">
            <div class="task_title">
              <h6>${task.title}</h6>
            </div>
            <div class="task_todo">
            </div>
          </div>`);
        }
        html = html.concat(`</div>`);
    });

    document.getElementById("progressState").innerText =
        nbTaskAchieve + "/" + list_task.length;
    document.getElementById("progressValue").style.width = taskPourcent + "%";
    //Global stats
    document.getElementById("globalTaskPourcent").innerText = taskPourcent + "%";
    document.getElementById("globalTaskProgress").style.width =
        taskPourcent + "%";

    if (dateSet != null) {
        document.getElementById("dateValue").innerText = dateSet;
    }

    return html;
}