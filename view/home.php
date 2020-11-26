<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@600&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/app.css">
  <link rel="stylesheet" href="assets/css/todo.css">
  <link rel="stylesheet" href="assets/css/stats.css">
  <link rel="stylesheet" href="assets/css/todoState.css">
  <title></title>
</head>

<body>
  <main>

    <div class="daySwitcher_container">
      <div class="button_container">
        <button>Précédent</button>
      </div>
      <div class="dayTitle_container">
        <h1>Jour</h1>
      </div>
      <div class="button_container">
        <button>Suivant</button>
      </div>
    </div>

    <div class="todo_container">
      <div class="todo_header" id="test">
        <h1 id='dayTitle'>Aujourd'hui</h1>
        <div class="progressBar_container">
          <div class="progressBar_bar" id='progressValue'>
            <!--Style css for width define in JS. -->
          </div>
        </div>
        <div class="taskInfo_container">
          <h3 id='progressState'><?= $nbTaskValidate . "/" . count($taskForToday) ?></h3>
        </div>
      </div>

      <div class="todo_content" id='todoContent'>
        <!-- Container for all the task -->
        <?php foreach ($taskForToday as $task) { ?>
          <div class="task_container">
            <?php if ($task->getActive() == 1) { ?>
              <div class="task_content_validate">
                <div class="task_title">
                  <h6><?= $task->getContent() ?></h6>
                </div>
                <div class="task_validate">
                  <img class="validate_icon" src="../assets\icons\checkmark_52px.png" alt="validate icon">
                </div>
              </div>
            <?php } else { ?>
              <div class="task_content_todo">
                <div class="task_title">
                  <h6><?= $task->getContent() ?></h6>
                </div>
                <div class="task_todo">
                </div>
              </div>
            <?php } ?>
            <img class="bin_icon" src="../assets\icons\trash_52px.png" alt="bin to delete">
          </div>
        <?php } ?>
        <button type="button" name="AddTask" class="btn_addClass">
          <h1>+</h1>
        </button>
      </div>

    </div>

    <div class="information_container">
      <div class="stats_container">
        <div class="stats_text_container">
          <h5>Taux d'accomplissement global des tâches</h5>
          <div class="stats_info_container">
            <h6>78%</h6>
          </div>
        </div>
        <div class="stats_progressBar_container">
          <div class="stats_progressBar">
            <div class="stats_progressBar_indicator">

            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="todoState_container">
      <div class="todoState_header">
        <h1>Etat d'avancement de vos Todo</h1>
      </div>
      <div class="todoState_card_container">

        <div class="card_container">
          <div class="card_header_date">
            <h2>19/12/2020</h2>
          </div>
          <div class="card_logo_container">
            <div class="card_logo">
              <img src="../assets\icons\todo_icon\house_48px.png" alt="house">
            </div>
          </div>
          <div class="card_content">
            <h3>Décoration Chambre</h3>
          </div>
          <div class="card_progressBar_container">
            <div class="card_progressBar">
              <div class="card_progressBar_indicator">
              </div>
            </div>
          </div>
        </div>

        <div class="card_container">
          <div class="card_header_date">
            <h2>19/12/2020</h2>
          </div>
          <div class="card_logo_container">
            <div class="card_logo">
              <img src="../assets\icons\todo_icon\house_48px.png" alt="house">
            </div>
          </div>
          <div class="card_content">
            <h3>Décoration Chambre</h3>
          </div>
          <div class="card_progressBar_container">
            <div class="card_progressBar">
              <div class="card_progressBar_indicator">
              </div>
            </div>
          </div>
        </div>

        <div class="card_container">
          <div class="card_header_date">
            <h2>19/12/2020</h2>
          </div>
          <div class="card_logo_container">
            <div class="card_logo">
              <img src="../assets\icons\todo_icon\house_48px.png" alt="house">
            </div>
          </div>
          <div class="card_content">
            <h3>Décoration Chambre</h3>
          </div>
          <div class="card_progressBar_container">
            <div class="card_progressBar">
              <div class="card_progressBar_indicator">
              </div>
            </div>
          </div>
        </div>

        <div class="card_container">
          <div class="card_header_date">
            <h2>19/12/2020</h2>
          </div>
          <div class="card_logo_container">
            <div class="card_logo">
              <img src="../assets\icons\todo_icon\house_48px.png" alt="house">
            </div>
          </div>
          <div class="card_content">
            <h3>Décoration Chambre</h3>
          </div>
          <div class="card_progressBar_container">
            <div class="card_progressBar">
              <div class="card_progressBar_indicator">
              </div>
            </div>
          </div>
        </div>

        <div class="card_container">
          <div class="card_header_date">
            <h2>19/12/2020</h2>
          </div>
          <div class="card_logo_container">
            <div class="card_logo">
              <img src="../assets\icons\todo_icon\house_48px.png" alt="house">
            </div>
          </div>
          <div class="card_content">
            <h3>Décoration Chambre</h3>
          </div>
          <div class="card_progressBar_container">
            <div class="card_progressBar">
              <div class="card_progressBar_indicator">
              </div>
            </div>
          </div>
        </div>

        <div class="card_container">
          <div class="card_header_date">
            <h2>19/12/2020</h2>
          </div>
          <div class="card_logo_container">
            <div class="card_logo">
              <img src="../assets\icons\todo_icon\house_48px.png" alt="house">
            </div>
          </div>
          <div class="card_content">
            <h3>Nouvel An Soirée</h3>
          </div>
          <div class="card_progressBar_container">
            <div class="card_progressBar">
              <div class="card_progressBar_indicator">
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </main>

  <footer>
    <div class="headerTodo_switcher_1">
      <img src="../assets/icons/chevron_left_127px.png" alt="précédent">
      <h6>Précédent</h6>
    </div>
    <div class="headerTodo_title">
      <h1>Jour</h1>
    </div>
    <div class="headerTodo_switcher_2">
      <h6>Suivant</h6>
      <img src="../assets/icons/chevron_right_127px.png" alt="suivant">
    </div>
  </footer>
  <script src="js/test.js"></script>

</body>

<footer>
  <div class="button_container_menu">
    <div class="button_menu_1">
    </div>
    <div class="button_menu_2">
    </div>
    <div class="button_menu_3">
    </div>
  </div>
</footer>

</html>