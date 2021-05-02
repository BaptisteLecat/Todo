<?php ob_start(); ?>
<main>
    <header>
        <div class="header_top">
            <img id="left-side_icon" src="..\..\assets\icons\left-arrow.png" class="previousPage" onclick="document.location.href='<?= $this->goPrevious() ?>'">
        </div>

        <div class="header_bottom">
            <h1>Ajout d'une tâche</h1>
        </div>
    </header>
    <form method="POST">
        <div class="input_container">
            <label>Todo de référence</label>
            <select name="todo-selector" id="todo">
                <?php foreach ($this->user->getList_Todo() as $todo) { ?>
                    <option value="<?= $todo->getId() ?>"><?= $todo->getTitle() ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="input_container">
            <label>Titre</label>
            <input type="text" name="title" placeholder="Faire les courses.." required></input>

        </div>
        <div class="input_container">
            <label>Contenu</label>
            <textarea name="content" placeholder="Acheter les aliments pour le repas.." required></textarea>

        </div>
        <div class="input_container">
            <label>A réaliser avant le</label>
            <input name="endDate" type="date" value="<?= date('Y-m-d'); ?>">
        </div>
        <div class="input_container">
            <label>Priorité</label>
            <select name="priority-selector" id="priority">
                <?php foreach ($this->app->getList_Priority() as $priority) { ?>
                    <option value="<?= $priority->getId() ?>"><?= $priority->getLabel() ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="input_container">
            <button type="submit">Rajouter du boulot</button>
            <input type="button" value="Créer une Todo"></input>
        </div>
    </form>
</main>

<?php $this->content = ob_get_clean(); ?>