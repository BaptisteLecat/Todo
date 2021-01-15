<?php ob_start(); ?>
<header>
    <img src="../assets/icons/logoTodo.png" alt="Logo Todo">
    <h1><span>Todo</span>List</h1>
</header>
<main>
    <div class="form_container">
        <div class="form_header">
            <div class="connexion_tab" onclick="document.location.href='index.php?view=login';">
                <h2>Connexion</h2>
            </div>
            <div class="register_tab">
                <h2>Enregistrement</h2>
            </div>
        </div>

        <?php if ($etape == 1) { ?>
            <form method="post">
                <div class="input_container">
                    <?php if (isset($error["input"])) {
                        switch ($error["input"]) {
                            case "first": ?>
                                <input style="border: 2px solid #b43030;" type="text" class="inputText" name="name" placeholder="Nom" value="<?php if (isset($registerInfo["name"])) {
                                                                                                                                                    echo ($registerInfo["name"]);
                                                                                                                                                } ?>">
                                <input type="text" class="inputText" name="firstname" placeholder="Prénom" value="<?php if (isset($registerInfo["firstname"])) {
                                                                                                                        echo ($registerInfo["firstname"]);
                                                                                                                    } ?>">
                                <?php break; ?>

                            <?php
                            case "second": ?>
                                <input type="text" class="inputText" name="name" placeholder="Nom" value="<?php if (isset($registerInfo["name"])) {
                                                                                                                echo ($registerInfo["name"]);
                                                                                                            } ?>">
                                <input style="border: 2px solid #b43030;" type="text" class="inputText" name="firstname" placeholder="Prénom" value="<?php if (isset($registerInfo["firstname"])) {
                                                                                                                                                            echo ($registerInfo["firstname"]);
                                                                                                                                                        } ?>">
                                <?php break; ?>

                            <?php
                            case "both": ?>
                                <input style="border: 2px solid #b43030;" type="text" class="inputText" name="name" placeholder="Nom" value="<?php if (isset($registerInfo["name"])) {
                                                                                                                                                    echo ($registerInfo["name"]);
                                                                                                                                                } ?>">
                                <input style="border: 2px solid #b43030;" type="text" class="inputText" name="firstname" placeholder="Prénom" value="<?php if (isset($registerInfo["firstname"])) {
                                                                                                                                                            echo ($registerInfo["firstname"]);
                                                                                                                                                        } ?>">
                        <?php break;
                        }
                    } else { ?>
                        <input type="text" class="inputText" name="name" placeholder="Nom" value="<?php if (isset($registerInfo["name"])) {
                                                                                                        echo ($registerInfo["name"]);
                                                                                                    } ?>">
                        <input type="text" class="inputText" name="firstname" placeholder="Prénom" value="<?php if (isset($registerInfo["firstname"])) {
                                                                                                                echo ($registerInfo["firstname"]);
                                                                                                            } ?>">
                    <?php } ?>
                </div>
                <div class="submit_container">
                    <input type="submit" class="sender" name="sender" value="">
                </div>
            </form>
        <?php } else { ?>
            <?php if ($etape == 2) { ?>
                <form method="post">
                    <div class="input_container">
                        <input type="hidden" name="etape" value="2">
                        <?php if (isset($error["input"])) {
                            switch ($error["input"]) {
                                case "first": ?>
                                    <input style="border: 2px solid #b43030;" type="text" class="inputText" name="email" placeholder="Email" value="<?php if (isset($registerInfo["email"])) {
                                                                                                                                                        echo ($registerInfo["email"]);
                                                                                                                                                    } ?>">
                                    <input type="password" class="inputText" name="password" placeholder="Mot de Passe" value="<?php if (isset($registerInfo["password"])) {
                                                                                                                                    echo ($registerInfo["password"]);
                                                                                                                                } ?>">
                                    <?php break; ?>

                                <?php
                                case "second": ?>
                                    <input type="text" class="inputText" name="email" placeholder="Email" value="<?php if (isset($registerInfo["email"])) {
                                                                                                                        echo ($registerInfo["email"]);
                                                                                                                    } ?>">
                                    <input style="border: 2px solid #b43030;" type="password" class="inputText" name="password" placeholder="Mot de Passe" value="<?php if (isset($registerInfo["password"])) {
                                                                                                                                                                        echo ($registerInfo["password"]);
                                                                                                                                                                    } ?>">
                                    <?php break; ?>

                                <?php
                                case "both": ?>
                                    <input style="border: 2px solid #b43030;" type="text" class="inputText" name="email" placeholder="Email" value="<?php if (isset($registerInfo["email"])) {
                                                                                                                                                        echo ($registerInfo["email"]);
                                                                                                                                                    } ?>">
                                    <input style="border: 2px solid #b43030;" type="password" class="inputText" name="password" placeholder="Mot de Passe" value="<?php if (isset($registerInfo["password"])) {
                                                                                                                                                                        echo ($registerInfo["password"]);
                                                                                                                                                                    } ?>">
                            <?php break;
                            }
                        } else { ?>
                            <input type="text" class="inputText" name="email" placeholder="Email" value="<?php if (isset($registerInfo["email"])) {
                                                                                                                echo ($registerInfo["email"]);
                                                                                                            } ?>">
                            <input type="password" class="inputText" name="password" placeholder="Mot de Passe" value="<?php if (isset($registerInfo["password"])) {
                                                                                                                            echo ($registerInfo["password"]);
                                                                                                                        } ?>">
                        <?php } ?>
                    </div>
                    <div class="submit_container">
                        <input type="submit" class="sender" name="sender" value="">
                    </div>
                </form>
        <?php }
        } ?>
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