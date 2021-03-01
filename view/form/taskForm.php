<?php ob_start(); ?>
<main>
    <header>
        <img src="assets\icons\left-arrow.png" class="previousPage" onclick="document.location.href='home'">
        <div class="header_title">
            <h1>Création d'une Tâche</h1>
        </div>
    </header>
    <form method="post">
        <div class="form_switcher" onclick="document.location.href='form/createtodo'">
            <h3>Ajouter un Todo</h3>
        </div>
        <h6>Todo de référence</h6>
        <select name="todo-selector" id="todo">
            <?php foreach ($this->user->getList_Todo() as $todo) { ?>
                <option value="<?= $todo->getId() ?>"><?= $todo->getTitle() ?></option>
            <?php } ?>
        </select>

        <h6>Contenu de la Tâche</h6>
        <textarea name="content" required></textarea>

        <div class="titleInput_container">
            <h6>Date de fin</h6>
            <img src="assets\icons\information.png">
        </div>
        <input class="bug" name="date" type="date" value="<?= date('Y-m-d'); ?>">

        <input type="submit" value="Valider">
    </form>
</main>

<?php $this->content = ob_get_clean(); ?>