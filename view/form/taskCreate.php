<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="stylesheet" href="assets/css/form/createTask.css">
    <link rel="stylesheet" href="assets/css/messageBox/information.css">
    <title>TaskForm</title>
</head>

<body onload="showMessageBox()">
    <?php if ($messageBox != null) {
        include("messageBox/information.php");
    } ?>
    <img src="assets\icons\chevron_left_127px.png" class="previousPage">
    <header>
        <div class="header_title">
            <h1>Création d'une Tâche</h1>
        </div>
    </header>
    <main>
        <form method="post">
            <div class="form_switcher">
                <h3 onclick="document.location.href='form_TaskTodo.php?form=CreateTodo'">Ajouter un Todo</h3>
            </div>
            <h6>Todo de référence</h6>
            <select name="todo-selector" id="todo">
                <?php foreach ($user->getListTodo() as $todo) { ?>
                    <option value="<?= $todo->getId() ?>"><?= $todo->getTitle() ?></option>
                <?php } ?>
            </select>

            <h6>Contenu de la Tâche</h6>
            <textarea name="content" required></textarea>

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

            <input type="submit" value="Valider">
        </form>
    </main>

    <script src="module/form/messageBox/messageBoxDisplayer.js"></script>
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