  <?php ob_start(); ?>
  <main>
      <header>
          <img src="assets\icons\left-arrow.png" class="previousPage" onclick="document.location.href='home'">
          <div class="header_title">
              <h1>Création d'un Todo</h1>
          </div>
      </header>
      <form method="post">
          <div class="form_switcher" onclick="document.location.href='form/createtask'">
              <h3>Ajouter une Tâche</h3>
          </div>
          <h6>Titre</h6>
          <input type="text" name="title" required>

          <h6>Description</h6>
          <textarea name="description" required></textarea>

          <h6>Icone</h6>
          <div class="todoIcon_container">
              <?php foreach ($list_todoIcons as $index => $icons) { ?>
                  <img name="<?= $index ?>" id="<?= $icons->getId(); ?>" src="assets/icons/todo_icon/<?= $icons->getLabel(); ?>.png" alt="<?= $icons->getLabel(); ?>" onclick="selectIcon(this)">
              <?php } ?>
          </div>

          <input type="hidden" name="icon" id='icon_id' value="1">
          <input type="submit" value="Valider">
      </form>
  </main>

  <script src="module/form/messageBox/messageBoxDisplayer.js"></script>
  <script src="module/form/todoform/todoCreateDisplayer.js"></script>

  <?php $this->content = ob_get_clean(); ?>