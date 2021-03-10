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

        }
                        <h6>ACHEVEE</h6>
                    <?php } else { ?>
                        <h6>INACHEVEE</h6>
                    <?php } ?>
                    <hr>
                    <div class='task_body'>
                        <div class='task_content'>
                            <h3>Travail</h3>
                            <p><?= $task->getContent(); ?></p>
                        </div>
                    </div>
                    <div class='task_footer'>
                        <div class='task_info'>
                            <img src="assets\\icons\\todo_task\\calendar.png" alt="">
                            <p>nothing</p>
                        </div>
                        <div class='task_info'>
                            <img src="assets\\icons\\todo_task\\user.png" alt="">
                            <p>2 personnes</p>
                        </div>
                    </div>
                </div>
            </div>`);
    });
}