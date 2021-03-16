<?php ob_start(); ?>
<main>
    <header>
        <div class="header_side">
            <img id="left-side_icon" src="assets\icons\left-arrow.png" class="previousPage" onclick="document.location.href='board'">
        </div>

        <div class="header_middle">
            <h1 id="todoName" name="<?= $todo->getId(); ?>"><?= $todo->getTitle(); ?></h1>
            <h2>de Baptiste Lecat</h2>
        </div>

        <div class="header_side">
            <img id="right-side_icon" src="assets\icons\settings.png" class="previousPage" onclick="document.location.href='board/<?= $todo->getId(); ?>/settings'">
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

    <div class="archive_container">
        <input id="cancel" onclick="cancelArchive()" type="button" value="Annuler">
        <input id="archive" onclick="archiveTask()" type="button" value="Archiver">
    </div>

    <div class='task_wrapper'>

        <?php foreach ($todo->getList_Task() as $task) { ?>
            <div class="parent_container">
                <div class="back_card">
                    <img src="assets\icons\writing.png">
                </div>
                <?php if ($task->isAchieve()) { ?>
                    <div class='task_container' style="background: linear-gradient(90deg, #5C7AFF, #5C7AFF);" name="<?= $task->getId(); ?>">
                        <h6 style="color: <?= $task->getPriorityObject()->getColor(); ?>"><?= $task->getPriorityObject()->getLabel(); ?></h6>
                        <hr style="border-color: #90A0E8;">
                        <div class='task_body'>
                            <div class='task_content' style="border-color: <?= $task->getPriorityObject()->getColor(); ?>;">
                                <h3><?= $task->getTitle(); ?></h3>
                                <p><?= $task->getContent(); ?></p>
                            </div>
                        </div>
                        <div class='task_footer'>
                            <div class='task_info'>
                                <img src="assets\icons\todo_task\calendar.png" alt="">
                                <p style="color: #FFF"><?= $task->getEndDate(); ?></p>
                            </div>
                        </div>
                    </div>
            </div>
        <?php } else { ?>
            <div class='task_container' name="<?= $task->getId(); ?>">
                <h6 style="color: <?= $task->getPriorityObject()->getColor(); ?>"><?= $task->getPriorityObject()->getLabel(); ?></h6>
                <hr>
                <div class='task_body'>
                    <div class='task_content' style="border-color: <?= $task->getPriorityObject()->getColor(); ?>;">
                        <h3><?= $task->getTitle(); ?></h3>
                        <p><?= $task->getContent(); ?></p>
                    </div>
                </div>
                <div class='task_footer'>
                    <div class='task_info'>
                        <img src="assets\icons\todo_task\calendar.png" alt="">
                        <p><?= $task->getEndDate(); ?></p>
                    </div>
                </div>
            </div>
    </div>
<?php } ?>
<?php } ?>
</div>
</main>

<script src="../js/todo/editSwipeHandler.js"></script>
<script src="../js/todo/archivePressHandler.js"></script>
<script src="../js/todo/archiveButtonManager.js"></script>
<script src="../js/todo/todo.js"></script>
<script src="../module/displayer/taskDisplayer.js"></script>
<script src="../module/task/archive/archive.js"></script>
<script src="../module/task/achieve/achieve.js"></script>

<?php $this->content = ob_get_clean(); ?>