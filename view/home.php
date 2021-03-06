<?php ob_start(); ?>
<main>

  <!--<div class="daySwitcher_container">
    <div id='previousSwitcher' class="button_container">
      <button onclick="dayBefore()">Précédent</button>
    </div>
    <div class="dayTitle_container">
      <h1 id='dayTitle'><?= $dayTitle ?></h1>
    </div>
    <div id='nextSwitcher' class="button_container">
      <button onclick="dayNext()">Suivant</button>
    </div>
  </div>-->
  <header>
    <h1>Paramètres</h1>
    <div class="account" onclick="document.location.href='account'">
      <img src="..\..\assets\icons\settings\user.svg">
      <h5>Compte</h5>
    </div>
  </header>

  <div class="todo_container">

    <div class="daySwitcher_container">
      <img id="previousSwitcher" src="..\..\assets\icons\chevron_left_127px.png" onclick="dayBefore()">
      <h1 id='dayTitle'><?= $dayTitle ?></h1>
      <img id="nextSwitcher" src="..\..\assets\icons\chevron_right_127px.png" onclick="dayNext()">
    </div>

    <div class="todo_header">
      <div id="left">
        <h1 id='dateValue'><?= $dateString ?></h1>
      </div>

      <div id="right">
        <div class="taskInfo_container">
          <h3 id='progressState'><?= $nbTaskValidateToday . "/" . count($taskForToday) ?></h3>
        </div>
      </div>

      <div id="filler">
        <div class="progressBar_container">
          <div class="progressBar_bar" id='progressValue' style="width: <?= $progressValidateToday ?>%"></div>
        </div>
      </div>


    </div>

    <div class="todo_content" id='todoContent'>
      <!-- Container for all the task -->
      <?php foreach ($taskForToday as $task) { ?>
        <div class="task_container" id="<?= $task->getId() ?>">
          <?php if ($task->isAchieve() == true) { ?>
            <div class="task_content_validate" id="<?= $task->getId() ?>" onclick="achieveTask(<?= $task->getId() ?>)">
              <div class="task_title">
                <h6><?= $task->getTitle() ?></h6>
              </div>
              <div class="task_validate">
                <img class="validate_icon" src="../assets\icons\checkmark_52px.png" alt="validate icon">
              </div>
            </div>
          <?php } else { ?>
            <div class="task_content_todo" id="<?= $task->getId() ?>" onclick="achieveTask(<?= $task->getId() ?>)">
              <div class="task_title">
                <h6><?= $task->getTitle() ?></h6>
              </div>
              <div class="task_todo">
              </div>
            </div>
          <?php } ?>
        </div>
      <?php } ?>
    </div>

  </div>

  <div class="information_container">
    <div class="stats_container">
      <div class="stats_text_container">
        <h5>Taux d'accomplissement global des tâches</h5>
        <div class="stats_info_container">
          <h6 id="globalTaskPourcent"><?= round($this->user->progressValuePercent()); ?>%</h6>
        </div>
      </div>
      <div class="stats_progressBar_container">
        <div class="stats_progressBar">
          <div class="stats_progressBar_indicator" id="globalTaskProgress" style="width:<?= $this->user->progressValuePercent(); ?>%">

          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="calendar_container">

    <div class="calendar_header">
      <div class="switcher_month" onclick="monthBefore()">
      </div>
      <h1 id='calendar_title'><?= $calendar->getMonth() . " " . $calendar->getYear(); ?></h1>
      <div class="switcher_month" onclick="monthNext()">
      </div>
    </div>

    <div class="calendar_content" id='calendar_content'>

      <?php echo $calendar->calendarDisplayer(); ?>

    </div>
  </div>
</main>

<script src="module/home/taskDisplayer/displayTask.js"></script>
<script src="module/home/taskDisplayer/switcherDay.js"></script>
<script src="module/home/taskDisplayer/achieveTask/achieveTask.js"></script>
<script src="module/home/taskDisplayer/switchDay/switchDay.js"></script>
<script src="module/calendar/calendarDisplayer.js"></script>

<?php $this->content = ob_get_clean(); ?>