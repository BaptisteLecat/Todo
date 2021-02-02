<?php ob_start(); ?>
<header>
  <img src="../assets/icons/logoTodo.png" alt="Logo Todo">
  <h1><span>Todo</span>List</h1>
</header>
<main>
  <div class="form_container">
    <div class="form_header">
      <div class="connexion_tab">
        <h2>Connexion</h2>
      </div>
      <div class="register_tab" onclick="document.location.href='register';">
        <h2>Enregistrement</h2>
      </div>
    </div>
    <form method="post">
      <div class="input_container">
        <?php if (isset($error["type"])) {
          switch ($error["type"]) {
            case 'email': ?>
              <input style="border: 2px solid #b43030;" type="text" class="inputText" name="email" placeholder="Email">
              <input type="password" class="inputText" name="password" placeholder="Mot de Passe">

              <?php break; ?>

            <?php
            case 'login': ?>
              <input style="border: 2px solid #b43030;" type="text" class="inputText" name="email" placeholder="Email">
              <input style="border: 2px solid #b43030;" type="password" class="inputText" name="password" placeholder="Mot de Passe">
              <?php break; ?>

            <?php
            case 'emptyEmail': ?>
              <input style="border: 2px solid #b43030;" type="text" class="inputText" name="email" placeholder="Email">
              <input type="password" class="inputText" name="password" placeholder="Mot de Passe">
              <?php break; ?>

            <?php
            case 'emptyPassword': ?>
              <input type="text" class="inputText" name="email" placeholder="Email">
              <input style="border: 2px solid #b43030;" type="password" class="inputText" name="password" placeholder="Mot de Passe">
              <?php break; ?>

          <?php }
        } else { ?>
          <input type="text" class="inputText" name="email" placeholder="Email">
          <input type="password" class="inputText" name="password" placeholder="Mot de Passe">
        <?php } ?>
      </div>
      <div class="submit_container">
        <input type="submit" class="sender" name="sender" value="">
      </div>
    </form>
    <div class="form_footer">
      <div class="formFooter_error">
        <?php if (isset($error["type"])) { ?>
          <h6><?= $error["message"] ?></h6>
        <?php } ?>
      </div>
      <div class="formFooter_link">
        <h6><a href="losePassword.php">Mot de passe oublié?</a></h6>
        <h6>Vous n'avez pas encore de compte?</h6>
        <div>
        </div>
      </div>
</main>

<?php $this->content = ob_get_clean(); ?>