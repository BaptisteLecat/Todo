<?php ob_start(); ?>
<main>
    <header>
        <div class="header_side">
            <img id="left-side_icon" src="assets\icons\left-arrow.png" class="previousPage" onclick="document.location.href='index?view=home'">
        </div>

        <div class="header_middle">
            <h1>Travail</h1>
            <h2>Janvier 15 2021</h2>
        </div>

        <div class="header_side">
            <img id="right-side_icon" src="assets\icons\left-arrow.png" class="previousPage" onclick="document.location.href='index?view=home'">
        </div>
    </header>

    <div class='log_container'>
        <div class="log_background">

        </div>
        <div class="log_box">
            <div class="log_wrapper">
                <div class="log_content">
                    <div class="content_left">
                        <h5>1h</h5>
                    </div>
                    <div class="content_right">
                        <h6>Baptiste Lecat</h6>
                        <p>Modification des informations de la tâche : <span>Rangement</span></p>
                    </div>
                </div>

                <div class="log_content">
                    <div class="content_left">
                        <h5>4h</h5>
                    </div>
                    <div class="content_right">
                        <h6>Baptiste Lecat</h6>
                        <p>Archivage de la tâche : Cahier des charges</p>
                    </div>
                </div>

                <div class="log_content">
                    <div class="content_left">
                        <h5>1h</h5>
                    </div>
                    <div class="content_right">
                        <h6>Baptiste Lecat</h6>
                        <p>Réalisation de la tâche : Diagramme de classe</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class='task_wrapper'>

        <?php foreach ($todo->getListTask() as $task) { ?>
            <div class="parent_container">
                <div class="back_card">
                    <img src="assets\icons\todo_task\user.png">
                    <img src="assets\icons\todo_task\user.png">
                </div>
                <div class='task_container'>
                    <h6>URGENT</h6>
                    <hr>
                    <div class='task_body'>
                        <div class='task_content'>
                            <h3>Travail</h3>
                            <p><?= $task->getContent(); ?></p>
                        </div>
                    </div>
                    <div class='task_footer'>
                        <div class='task_info'>
                            <img src="assets\icons\todo_task\calendar.png" alt="">
                            <p><?= $task->getEndDate(); ?></p>
                        </div>
                        <div class='task_info'>
                            <img src="assets\icons\todo_task\user.png" alt="">
                            <p>2 personnes</p>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</main>

<script>
    $(".task_container").on("swipeleft", function() {
        $(".task_container").each(function() {
            $(this).removeClass("retract");
        });
        $(this).toggleClass("retract");
    });


    $(".task_container").on("swiperight", function() {
        $(this).removeClass("retract");
    });
</script>

<?php $this->content = ob_get_clean(); ?>