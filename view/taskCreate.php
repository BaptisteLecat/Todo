<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="stylesheet" href="assets/css/taskForm.css">
    <link rel="stylesheet" href="assets/css/messageBox/information.css">
    <title>TaskForm</title>
</head>

<body onload="showMessageBox()">
<?php if($messageBox != null){include("messageBox/information.php");} ?>
    <img src="assets\icons\chevron_left_127px.png" class="previousPage">
    <header>
        <div class="header_title">
            <h1>Création d'une Tâche</h1>
        </div>
    </header>
    <main>
        <form method="post">
            <h6>Todo de référence</h6>
            <select name="todo-selector" id="todo">
                <?php foreach ($user->getListTodo() as $todo) { ?>
                    <option value="<?= $todo->getId() ?>"><?= $todo->getTitle() ?></option>
                <?php } ?>
            </select>

            <h6>Contenu de la Tâche</h6>
            <textarea name="content" required></textarea>
            <!--//TODO Faire le petit "i" informations, avec la messageBox associé.-->

            <div class="titleInput_container">
                <h6>Date de fin</h6>
                <img src="assets\icons\information.png">
            </div>
            <input name="date" type="date">

            <div class="titleInput_container">
                <h6>Heure de fin</h6>
                <img src="assets\icons\information.png">
            </div>
            <input name="time" type="time">
            <!--//TODO Faire le JS qui permet de changer l'etat du btn click et la value du hidden.-->

            <input type="submit" value="Valider">
        </form>
    </main>

    <script src="module/taskform/taskCreateDisplayer.js"></script>
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