<?php

/*require_once '../modele/accesBD.php';
require_once '../modele/class_job/class_todo.php';
require_once '../modele/class_job/class_user.php';
require_once '../modele/class_job/class_task.php';*/

$connexion = new accesBD();

$user = new User(1, "Test", "Test", "rt", "rt");
$date = date("y-m-d");

$todoDay = new Todo(1, "Aujourd'hui", null, null, $user);

$resultLoadTask = $connexion->REQTask_LoadTaskFromIdUser($user->GET_Id(), $date);
if($resultLoadTask["success"] != 0){
  if($resultLoadTask["listeTask"] != null){
    foreach($resultLoadTask["listeTask"] as $key => $value){
      $task = new Task($value["id_task"], $value["content_task"], $value["enddate_task"], $value["endtime_task"], $value["active_task"], $todoDay, $user);
    }
  }else{
    //Aucune Task;
  }
}else{
  //erreur.
}

echo '<div class="todo_container">

  <div class="todo_header">
    <h1>'.$todoDay->GET_Title().'</h1>
    <div class="progressBar_container">
      <div class="progressBar_bar" style=" width:'.$todoDay->ProgressValuePourcent().'%;">
      </div>
    </div>
    <div class="taskInfo_container">
      <h3>'.$todoDay->NbTaskValidate().'/'.count($todoDay->GET_ListeTask()).'</h3>
    </div>
  </div>
   <script type="text/javascript" src="../assets/js/displayAllDailyTask.js"></script>

  <div class="todo_content">';
$compteur = 0;
foreach ($todoDay->GET_ListeTask() as $key => $value) {
  $compteur++;
  if($compteur <= 3){
    if ($value->GET_Active() == 1) {
      echo '        <div class="task_container">
                <div class="task_content_validate">
                  <div class="task_title">
                    <h6>'.$value->GET_Content().'</h6>
                    <p>14 Juillet 2020</p>
                  </div>
                  <div class="task_validate">
                    <img class="validate_icon" src="../assets\icons\checkmark_52px.png" alt="validate icon">
                  </div>
                </div>
                <img class="bin_icon" src="../assets\icons\trash_52px.png" alt="bin to delete">
              </div>';
    }else {
      echo '<div class="task_container">
        <div class="task_content_todo" onclick="DisplayInfo(this);">
        <div class="task_title">
          <h6>'.$value->GET_Content().'</h6>
          <p>14 Juillet 2020</p>
        </div>
          <div class="task_todo">
          </div>
        </div>
        <img class="bin_icon" src="../assets\icons\trash_52px.png" alt="bin to delete">
      </div>';
    }
    if($compteur == 3 ){
      echo '<button type="button" name="AddTask" class="btn_addClass" onclick="DisplayTask()"><h1>+</h1></button></div>
          </div>';
          break;
    }
  }else{
    if ($value->GET_Active() == 1) {
      echo '        <div class="task_container">
                <div class="task_content_validate">
                  <div class="task_title">
                    <h6>'.$value->GET_Content().'</h6>
                    <p>14 Juillet 2020</p>
                  </div>
                  <div class="task_validate">
                    <img class="validate_icon" src="../assets\icons\checkmark_52px.png" alt="validate icon">
                  </div>
                </div>
                <img class="bin_icon" src="../assets\icons\trash_52px.png" alt="bin to delete">
              </div>';
    }else {
      echo '<div class="task_container">
        <div class="task_content_todo" onclick="DisplayInfo(this);">
        <div class="task_title">
          <h6>'.$value->GET_Content().'</h6>
          <p>14 Juillet 2020</p>
        </div>
          <div class="task_todo">
          </div>
        </div>
        <img class="bin_icon" src="../assets\icons\trash_52px.png" alt="bin to delete">
      </div>';
    }
      echo '<button type="button" name="AddTask" class="btn_addClass" onclick="DisplayTask()"><h1>+</h1></button></div>
          </div>';
  }
}



 ?>
