function todoDisplayer(listTaskObject){
    var html = "";
    listTaskObject.forEach(task => {
        html = html.concat(`            <div class="parent_container">
                <div class="back_card">
                    <img src="assets\\icons\\writing.png">
                </div>
                <div class='task_container' name="<?= $task->getId(); ?>">
                `);
        if(task.isAchieve){
            html = html.concat(`
                    <div class='task_container' style="background: linear-gradient(90deg, #5C7AFF, #5C7AFF);" name="${task.id}">
                        <h6 style="color: ${task.priorityObject.color}">${task.priorityObject.label}</h6>
                        <hr style="border-color: #90A0E8;">
                        <div class='task_body'>
                            <div class='task_content' style="border-color: ${task.priorityObject.color};">
                                <h3>Travail</h3>
                                <p>${task.content}</p>
                            </div>
                        </div>
                        <div class='task_footer'>
                            <div class='task_info'>
                                <img src="assets\\icons\\todo_task\\calendar.png" alt="">
                                <p style="color: #FFF">${task.endDate}</p>
                            </div>
                        </div>
                    </div>
            </div>`);
        }else{
            html = html.concat(`            <div class='task_container' name="${task.id}">
                <h6 style="color: ${task.priorityObject.color}">${task.priorityObject.label}</h6>
                <hr>
                <div class='task_body'>
                    <div class='task_content' style="border-color: ${task.priorityObject.color};">
                        <h3>Travail</h3>
                        <p>${task.content}</p>
                    </div>
                </div>
                <div class='task_footer'>
                    <div class='task_info'>
                        <img src="assets\\icons\\todo_task\\calendar.png" alt="">
                        <p>${task.endDate}</p>
                    </div>
                </div>
            </div>`);
        }

        html = html.concat(`</div></div>`);
                        
    });

    return html;
}