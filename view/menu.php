<?php ob_start(); ?>
<div class="menu">

  <div class="widget_plus" onclick="AddTodo()">
    <img src="assets/icons/navbar/plus.png">
  </div>

  <div class="navbar">
    <div class="nav_button" onclick="ChangePage('todo')">
      <?php if ($view == "todo") { ?>
        <img id="icon_1" src="assets/icons/navbar/calendar_blue.png">
      <?php } else { ?>
        <img id="icon_1" src="assets/icons/navbar/calendar.png">
      <?php } ?>
      <h5 id="namePage_1">Todo</h5>
    </div>
    <div class="nav_button" onclick="ChangePage('home')">
      <?php if ($view == "home") { ?>
        <img id="icon_2" src="assets/icons/navbar/house_blue.png">
      <?php } else { ?>
        <img id="icon_2" src="assets/icons/navbar/house.png">
      <?php } ?>
      <h5 id="namePage_2">Accueil</h5>
    </div>
    <div class="nav_button" onclick="ChangePage('stats')">
      <?php if ($view == "stats") { ?>
        <img id="icon_3" src="assets/icons/navbar/bar-chart_blue.png">
      <?php } else { ?>
        <img id="icon_3" src="assets/icons/navbar/bar-chart.png">
      <?php } ?>
      <h5 id="namePage_3">Stats</h5>
    </div>
  </div>
  <div id="circle_back"></div>
  <div id="lineUnder"></div>
</div>

<?php if ($view == "todo") { ?>

  <script type="text/javascript">
    $("#circle_back").css("margin-left", "calc((100% - 204px) / 6 )");
    $("#lineUnder").css("margin-left", "calc((100% - 96px) / 6 )");

    $("#icon_1").css("margin-top", "-68px");

    $("#namePage_1").addClass("h5_blue");

    $("#namePage_2").css("margin-top", "85px");
    $("#namePage_3").css("margin-top", "85px");
  </script>

<?php } else if ($view == "home") { ?>

  <script type="text/javascript">
    $("#circle_back").css("margin-left", "calc(((100% - 204px) / 6 ) * 3 + 68px)");
    $("#lineUnder").css("margin-left", "calc(((100% - 96px) / 6 ) * 3 + 32px)");

    $("#icon_2").css("margin-top", "-68px");

    $("#namePage_2").addClass("h5_blue");

    $("#namePage_1").css("margin-top", "85px");
    $("#namePage_3").css("margin-top", "85px");
  </script>

<?php } else if ($view == "stats") { ?>

  <script type="text/javascript">
    $("#circle_back").css("margin-left", "calc(((100% - 204px) / 6 ) * 5 + 136px)");
    $("#lineUnder").css("margin-left", "calc(((100% - 96px) / 6 ) * 5 + 64px)");

    $("#icon_3").css("margin-top", "-68px");

    $("#namePage_3").addClass("h5_blue");

    $("#namePage_1").css("margin-top", "85px");
    $("#namePage_2").css("margin-top", "85px");
  </script>

<?php } ?>

<script type="text/javascript">
  function AddTodo() {
    window.location = "form";
  }


  function ChangePage(page) {
    setTimeout(function() {
      window.location = page;
    }, 600);


    $("#circle_back").addClass("transition_effet");
    $("#lineUnder").addClass("transition_effet");

    $("#icon_1").addClass("transition_effet");
    $("#icon_2").addClass("transition_effet");
    $("#icon_3").addClass("transition_effet");

    $("#namePage_1").addClass("transition_effet");
    $("#namePage_2").addClass("transition_effet");
    $("#namePage_3").addClass("transition_effet");


    if (page == 1) {
      $("#circle_back").css("margin-left", "calc((100% - 204px) / 6 )");
      $("#lineUnder").css("margin-left", "calc((100% - 96px) / 6 )");
      $("#lineUnder").css("background", "#fff");

      $("#icon_1").css("margin-top", "-68px");
      $("#icon_2").css("margin-top", "0px");
      $("#icon_3").css("margin-top", "0px");

      $("#namePage_1").css("margin-top", "8px");
      $("#namePage_2").css("margin-top", "85px");
      $("#namePage_3").css("margin-top", "85px");

      $("#namePage_1").css("opacity", "1");
      $("#namePage_2").css("opacity", "0");
      $("#namePage_3").css("opacity", "0");

    } else if (page == 2) {

      $("#circle_back").css("margin-left", "calc(((100% - 204px) / 6 ) * 3 + 68px)");
      $("#lineUnder").css("margin-left", "calc(((100% - 96px) / 6 ) * 3 + 32px)");
      $("#lineUnder").css("background", "#fff");

      $("#icon_2").css("margin-top", "-68px");
      $("#icon_1").css("margin-top", "0px");
      $("#icon_3").css("margin-top", "0px");

      $("#namePage_2").css("margin-top", "8px");
      $("#namePage_1").css("margin-top", "85px");
      $("#namePage_3").css("margin-top", "85px");

      $("#namePage_2").css("opacity", "1");
      $("#namePage_1").css("opacity", "0");
      $("#namePage_3").css("opacity", "0");

    } else if (page == 3) {

      $("#circle_back").css("margin-left", "calc(((100% - 204px) / 6 ) * 5 + 136px)");
      $("#lineUnder").css("margin-left", "calc(((100% - 96px) / 6 ) * 5 + 64px)");
      $("#lineUnder").css("background", "#fff");

      $("#icon_3").css("margin-top", "-68px");
      $("#icon_1").css("margin-top", "0px");
      $("#icon_2").css("margin-top", "0px");

      $("#namePage_3").css("margin-top", "8px");
      $("#namePage_1").css("margin-top", "85px");
      $("#namePage_2").css("margin-top", "85px");

      $("#namePage_3").css("opacity", "1");
      $("#namePage_1").css("opacity", "0");
      $("#namePage_2").css("opacity", "0");

    }
  }
</script>

<?php $this->content .= ob_get_clean(); ?>