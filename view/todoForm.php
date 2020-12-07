<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="stylesheet" href="assets/css/taskForm.css">
    <title>TaskForm</title>
</head>

<body>
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
            <textarea placeholder="Coucou"></textarea>

            <h6>Priorité</h6>
            <button>Normale</button><button>Normale</button>

            <h6>Date de fin</h6>
            <input type="date">

            <h6>Heure de fin</h6>
            <input type="time">
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