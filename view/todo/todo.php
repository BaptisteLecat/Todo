<?php ob_start(); ?>
<main>

    <header>
        <img src="assets\icons\left-arrow.png" class="previousPage" onclick="document.location.href='index?view=home'">
        <div class='header_container'>
            <div class='todo_info'>
                <h2>Janvier 15, 2021</h2>
                <h1><?= $todo->getTitle(); ?></h1>
            </div>
            <button class="btn_header">
                <img src="assets\icons\navbar\plus.png" alt="ajouter">
                <p>Modifier</p>
            </button>
        </div>
    </header>

    <div class='task_wrapper'>

        <?php foreach ($todo->getListTask() as $task) { ?>
            <div class='task_container'>
                <h6>URGENT</h6>
                <hr>
                <div class='task_body'>
                    <div class='statut_indicator'>
                    </div>
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
        <?php } ?>
    </div>
</main>

<?php $this->content = ob_get_clean(); ?>