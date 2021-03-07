<?php ob_start(); ?>
<main>

  <div class="title">
    <h1 class="name_title">Vos Todo</h1>
  </div>

  <div class="information_todo">
    <div class="todo_title">
      <h3 class="name_todo">Personnelle</h3>
    </div>
    <div class="color_number">
      <div class="number">
        <h3>3</h3>
      </div>
    </div>
  </div>
  <div class= "box_line">
    <hr class="line">
  </div>
  <div class="container_todoView">
    <?php foreach ($this->user->getList_Todo() as $todo) { ?>
      <div class="box_todoView" id="<?= $todo->getId(); ?>">

        <div class="box_icon">
          <img class="img_theme" src="assets/icons/todo_icon/<?= $todo->getTodoIconObject()->getLabel(); ?>.png">
        </div>

        <div class="box_theme">
          <h1 class="text_theme"><?= $todo->getTitle(); ?></h1>
        </div>

        <p><?= count($todo->getList_Task()); ?></p>

        <div class="progressBar">
          <div class="line_progressBar"></div>
        </div>
      </div>
    <?php } ?>
  </div>

  <div class="information_todo">
    <div class="todo_title">
      <h3 class="name_todo">Groupe</h3>
    </div>
    <div class="color_number">
      <div class="number">
        <h3>3</h3>
      </div>
    </div>
  </div>
  <div class= "box_line">
    <hr class="line">
  </div>

  <div class="container_todoView">
    <?php foreach ($this->user->getList_Todo() as $todo) { ?>
      <div class="box_todoView" id="<?= $todo->getId(); ?>">

        <div class="box_icon">
          <img class="img_theme" src="assets/icons/todo_icon/<?= $todo->getTodoIconObject()->getLabel(); ?>.png">
        </div>

        <div class="box_theme">
          <h1 class="text_theme"><?= $todo->getTitle(); ?></h1>
        </div>

        <p><?= count($todo->getList_Task()); ?></p>

        <div class="progressBar">
          <div class="line_progressBar"></div>
        </div>
      </div>
    <?php } ?>

  </div>
</main>
<?php $this->content = ob_get_clean(); ?>