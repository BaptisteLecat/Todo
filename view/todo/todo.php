<?php ob_start(); ?>
<main>
    <header>
        <div class="header_side">
            <img id="left-side_icon" src="assets\icons\left-arrow.png" class="previousPage" onclick="document.location.href='index?view=home'">
        </div>

        <div class="header_middle">
            <h1 id="todoName" name="<?= $todo->getId(); ?>"><?= $todo->getTitle(); ?></h1>
            <h2>de Baptiste Lecat</h2>
        </div>

        <div class="header_side">
            <img id="right-side_icon" src="assets\icons\settings.png" class="previousPage" onclick="document.location.href='index?view=home'">
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
                        <p>Modification des informations de la tâche : <span class="span-blue">Rangement</span></p>
                    </div>
                </div>

                <div class="log_content">
                    <div class="content_left">
                        <h5>4h</h5>
                    </div>
                    <div class="content_right">
                        <h6>Baptiste Lecat</h6>
                        <p>Archivage de la tâche : <span class="span-red">Cahier des charges</span></p>
                    </div>
                </div>

                <div class="log_content">
                    <div class="content_left">
                        <h5>1h</h5>
                    </div>
                    <div class="content_right">
                        <h6>Baptiste Lecat</h6>
                        <p>Réalisation de la tâche : <span class="span-blue">Diagramme de classe</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <button onclick="archiveTask()">Archive</button>

    <div class='task_wrapper'>

        <?php foreach ($todo->getList_Task() as $task) { ?>
            <div class="parent_container">
                <div class="back_card">
                    <img src="assets\icons\writing.png">
                </div>
                <div class='task_container' name="<?= $task->getId(); ?>">
                    <?php if ($task->isAchieve()) { ?>
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
                            <img src="assets\icons\todo_task\calendar.png" alt="">
                            <p>nothing</p>
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

<script src="../js/todo/editSwipeHandler.js"></script>
<script src="../js/todo/archivePressHandler.js"></script>
<script src="../js/todo/todo.js"></script>
<script src="../module/task/archive.js"></script>

<?php $this->content = ob_get_clean(); ?>