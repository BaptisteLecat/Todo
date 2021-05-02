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
              <label>Titre</label>
              <input type="text" name="title" placeholder="Faire les courses.." required></input>

          </div>
          <div class="input_container">
              <label>Description</label>
              <textarea name="description" placeholder="Acheter les aliments pour le repas.." required></textarea>

          </div>
          <div class="input_container">
              <label>Icone</label>
              <div class="icon_wrapper">
                  <?php foreach ($this->app->getList_TodoIcon() as $key => $icon) { ?>
                      <img name="<?= $key ?>" id="<?= $icon->getId() ?>" src="assets/icons/todo_icon/<?= $icon->getLabel() ?>.png" alt="<?= $icon->getLabel() ?>" onclick="selectIcon(this)">
                  <?php } ?>
              </div>
          </div>
          <div class="input_container">
              <button type="submit">Au travail</button>
              <a href="form/createtask">
                  <input type="button" value="Créer une Tâche"></input>
              </a>
          </div>
      </form>
  </main>

  <script src="module/form/messageBox/messageBoxDisplayer.js"></script>
  <script src="module/form/todoform/todoCreateDisplayer.js"></script>

  <?php $this->content = ob_get_clean(); ?>