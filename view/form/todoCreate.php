<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="stylesheet" href="assets/css/form/createTodo.css">
    <link rel="stylesheet" href="assets/css/messageBox/information.css">
    <title>TodoForm</title>
</head>

<body onload="showMessageBox()">
    <?php if ($messageBox != null) {
        include("messageBox/information.php");
    } ?>
    <img src="assets\icons\chevron_left_127px.png" class="previousPage">
    <header>
        <div class="header_title">
            <h1>Création d'un Todo</h1>
        </div>
    </header>
    <main>
        <form method="post">
            <div class="form_switcher">
                <h3 onclick="document.location.href='form_TaskTodo.php?form=CreateTask'">Ajouter une Tâche</h3>
            </div>
            <h6>Titre</h6>
            <input type="text" name="title" required>

            <h6>Description</h6>
            <textarea name="description" required></textarea>

            <h6>Statut</h6>
            <div class="status_container">
                <input type="button" id='private' value="Privé" onclick="btnStatus_click(this)" style="background-color: #5C7AFF">
                <input type="button" id='public' value="Publique" onclick="btnStatus_click(this)">
            </div>

            <div class="titleInput_container">
                <h6>Date de fin</h6>
                <img src="assets\icons\information.png">
            </div>
            <input class="bug" name="date" type="date">

            <div class="titleInput_container">
                <h6>Heure de fin</h6>
                <img src="assets\icons\information.png">
            </div>
            <input class="bug" name="time" type="time">

            <input type="hidden" name="status" id='status_value' value="private">
            <input type="submit" value="Valider">
        </form>
    </main>

    <script src="module/form/messageBox/messageBoxDisplayer.js"></script>
    <script src="module/form/todoform/todoCreateDisplayer.js"></script>
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