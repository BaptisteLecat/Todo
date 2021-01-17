<main>

  <div class="container_todoView">
    <?php foreach ($this->user->getListTodo() as $todo) { ?>
      <div class="box_todoView" id="<?= $todo->getId(); ?>">

        <div class="box_icon">
          <img class="img_theme" src="assets/icons/todo_icon/<?= $todo->getIconObject()->getLibelle(); ?>.png">
        </div>

        <div class="box_theme">
          <h1 class="text_theme"><?= $todo->getTitle(); ?></h1>
        </div>

        <p><?= count($todo->getListTask()); ?></p>

        <div class="progressBar">
          <div class="line_progressBar"></div>
        </div>
      </div>
    <?php } ?>

  </div>

</main>