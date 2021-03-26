<?php ob_start(); ?>
<main>

  <h1 class="name_title">Vos Todo</h1>

  <div class="container_todo">
    <div class="information_todo">
      <h3 class="name_todo">Personnelle</h3>
      <h3 class="number"><?= count($this->user->getList_Todo()); ?></h3>
    </div>
  </div>

  <div class="container_todoView">
    <?php foreach ($this->user->getList_Todo() as $todo) { ?>
      <div class="box_todoView" onclick="document.location.href = '<?= $_SERVER['REQUEST_URI'].'/'.$todo->getId(); ?>'" id="<?= $todo->getId(); ?>">

        <div class="box_icon">
          <img class="img_theme" src="assets/icons/todo_icon/<?= $todo->getTodoIconObject()->getLabel(); ?>.png">
        </div>

        <div class="box_theme">
          <h1 class="text_theme"><?= $todo->getTitle(); ?></h1>
        </div>

        <p><?= count($todo->taskTodo()); ?></p>

        <div class="progressBar">
          <div class="line_progressBar" style="width: <?= $todo->progressValuePercent() ?>%"></div>
        </div>
      </div>
    <?php } ?>
  </div>

  <div class="container_todo">
    <div class="information_todo">
      <h3 class="name_todo">Groupe</h3>
      <h3 class="number"><?= count($this->user->getList_TodoContribute()); ?></h3>
    </div>
  </div>

  <div class="container_todoView">
    <?php foreach ($this->user->getList_TodoContribute() as $todo) { ?>
      <div class="box_todoView" onclick="document.location.href = 'board/<?= $todo->getId(); ?>'" id="<?= $todo->getId(); ?>">

        <div class="box_icon">
          <img class="img_theme" src="assets/icons/todo_icon/<?= $todo->getTodoIconObject()->getLabel(); ?>.png">
        </div>

        <div class="box_theme">
          <h1 class="text_theme"><?= $todo->getTitle(); ?></h1>
        </div>

        <p><?= count($todo->taskTodo()); ?></p>

        <div class="progressBar">
          <div class="line_progressBar" style="width: <?= $todo->progressValuePercent() ?>%"></div>
        </div>
      </div>
    <?php } ?>

  </div>
</main>
<?php $this->content = ob_get_clean(); ?>