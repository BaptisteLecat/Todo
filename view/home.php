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
  <link rel="stylesheet" href="assets/css/calendar.css">
  <title>Accueil</title>
</head>

<body>
  <main>

    <div class="daySwitcher_container">
      <div id='previousSwitcher' class="button_container">
        <button onclick="dayBefore()">Précédent</button>
      </div>
      <div class="dayTitle_container">
        <h1 id='dayTitle'><?= $dayTitle ?></h1>
      </div>
      <div id='nextSwitcher' class="button_container">
        <button onclick="dayNext()">Suivant</button>
      </div>
    </div>

    <div class="todo_container">
      <div class="todo_header">

        <div id="left">
          <h1 id='dateValue'><?= $dateString ?></h1>
        </div>
        
        <div id="right">
          <div class="taskInfo_container">
            <h3 id='progressState'><?= $nbTaskValidate . "/" . count($taskForToday) ?></h3>
          </div>
        </div>

        <div id="filler">
          <div class="progressBar_container">
            <?php if (isset($taskForToday)) {
              if (count($taskForToday) > 0) {
                $value = ($nbTaskValidate / count($taskForToday)) * 100; ?>
                <div class="progressBar_bar" id='progressValue' style="width: <?= $value ?> %"></div>
              <?php } else { ?>
                <div class="progressBar_bar" id='progressValue' style="width: 0%"></div>
            <?php }
            } ?>
          </div>
        </div>
        
        
      </div>

      <div class="todo_content" id='todoContent'>
        <!-- Container for all the task -->
        <?php foreach ($taskForToday as $task) { ?>
          <div class="task_container" id="<?= $task->getId() ?>">
            <?php if ($task->getActive() == 1) { ?>
              <div class="task_content_validate" onclick="activeModifier(this)">
                <div class="task_title">
                  <h6><?= $task->getContent() ?></h6>
                </div>
                <div class="task_validate">
                  <img class="validate_icon" src="../assets\icons\checkmark_52px.png" alt="validate icon">
                </div>
              </div>
            <?php } else { ?>
              <div class="task_content_todo" id="<?= $task->getId() ?>" onclick="activeModifier(this)">
                <div class="task_title">
                  <h6><?= $task->getContent() ?></h6>
                </div>
                <div class="task_todo">
                </div>
              </div>
            <?php } ?>
            <img class="bin_icon" src="../assets\icons\trash_52px.png" alt="bin to delete" onclick="deleteTask(this)">
          </div>
        <?php } ?>
      </div>

    </div>

    <div class="information_container">
      <div class="stats_container">
        <div class="stats_text_container">
          <h5>Taux d'accomplissement global des tâches</h5>
          <div class="stats_info_container">
            <h6 id="globalTaskPourcent"><?= round($user->progressValuePourcent()); ?>%</h6>
          </div>
        </div>
        <div class="stats_progressBar_container">
          <div class="stats_progressBar">
            <div class="stats_progressBar_indicator" id="globalTaskProgress" style="width:<?= $user->progressValuePourcent(); ?>%">

            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="calendar_container">

      <div class="calendar_header">
        <div class="switcher_month">
        </div>
        <h1>Décembre 2020</h1>
        <div class="switcher_month">
        </div>
      </div>

      <div class="calendar_content">
        <table>
          <thead>
            <th>Lun</th>
            <th>Mar</th>
            <th>Mer</th>
            <th>Jeu</th>
            <th>Ven</th>
            <th>Sam</th>
            <th>Dim</th>
          </thead>
          <tbody>
            <tr>
              <td>ab</td>
              <td>1</td>
              <td>2</td>
              <td>3</td>
              <td>4</td>
              <td>5</td>
              <td>6</td>
            </tr>
            <tr>
              <td>7</td>
              <td>8</td>
              <td>9</td>
              <td>10</td>
              <td>11</td>
              <td>12</td>
              <td>13</td>
            </tr>
            <tr>
              <td>14</td>
              <td>15</td>
              <td>16</td>
              <td>17</td>
              <td>18</td>
              <td>19</td>
              <td>20</td>
            </tr>
            <tr>
              <td>21</td>
              <td>22</td>
              <td>23</td>
              <td>24</td>
              <td>25</td>
              <td>26</td>
              <td>27</td>
            </tr>
            <tr>
              <td>28</td>
              <td>29</td>
              <td>30</td>
              <td>31</td>
          </tbody>
        </table>
      </div>
    </div>
  </main>

  <button class="createBtn" onclick="document.location.href='form_TaskTodo.php'"><img src="..\assets\icons\plus_math_52px.png" alt="More"></button>

  <script src="module/taskDisplayer/taskDisplayer.js"></script>
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