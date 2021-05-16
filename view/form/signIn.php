<?php ob_start(); ?>

<main>
  <header>
    <img src="../assets/icons/logoTodo.png" alt="Logo Todo">
    <h1><span>Todo</span>List</h1>
  </header>

  <div class="form_container">

    <div class="form_header">
      <div class="connexion_tab">
        <h2>Connexion</h2>
      </div>
      <div class="register_tab" onclick="document.location.href='signUp';">
        <h2>Enregistrement</h2>
      </div>
    </div>

    <div class="container">
      <form method="post">
        <div class="input_container">
          <input type="text" class="inputText" name="email" placeholder="Email" required>
          <input type="password" class="inputText" name="password" placeholder="Mot de Passe" required>
          <input type="submit" class="sender" name="sender" value="">
          <div class="rememberMe">
            <input type="checkbox" name="remember" id="remember"><label for="remember">Rester connecté</label>
          </div>
        </div>
      </form>
      <div class="form_footer">
        <div class="formFooter_link">
          <h6><a href="losePassword.php">Mot de passe oublié?</a></h6>
          <div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<?php $this->content = ob_get_clean(); ?>