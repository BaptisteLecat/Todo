<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="stylesheet" href="assets/css/taskForm.css">
    <title>TaskForm</title>
</head>

<body>
    <img src="assets\icons\chevron_left_127px.png" class="previousPage">
    <header>
        <div class="header_title">
            <h1>Création d'une Tâche</h1>
        </div>
    </header>
    <main>
        <form action="">
            <h6>Todo de référence</h6>
            <select name="pets" id="pet-select">
                <option value="none">Aucune</option>
                <option value="5">Noël</option>
                <option value="12">Anniversaire</option>
                <option value="18">Courses</option>
            </select>

            <h6>Contenu de la Tâche</h6>
            <textarea required></textarea>

            <h6>Priorité</h6>
            <div class="btn_container">
                <input type="button" value="Normale">
                <input type="button" value="Importante">
            </div>
            <!--//TODO Faire le petit "i" informations, avec la messageBox associé.-->
            
            <div class="titleInput_container">
                <h6>Date de fin</h6>
                <img src="assets\icons\information.png">
            </div>
            <input type="date">

            <div class="titleInput_container">
                <h6>Heure de fin</h6>
                <img src="assets\icons\information.png">
            </div>
            <input type="time">
            <!--//TODO Faire le JS qui permet de changer l'etat du btn click et la value du hidden.-->
            <input type="hidden" value="">

            <input type="submit" value="Valider">
        </form>
    </main>
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