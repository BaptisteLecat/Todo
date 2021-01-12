<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@600&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/todoView.css">
  <link rel="stylesheet" href="assets/css/app.css">
  <title>TODO</title>
</head>

<body>

  <main>


    <div class="container_todoView">
      <?php foreach ($user->getListTodo() as $todo) { ?>
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

</body>

<footer>
  <div class="button_container_menu">
    <div class="button_menu_1" onclick="document.location.href = 'todoView.php'">
    </div>
    <div class="button_menu_2">
    </div>
    <div class="button_menu_3">
    </div>
  </div>
</footer>

</html>