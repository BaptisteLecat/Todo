<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="assets/css/register.css">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title></title>
</head>

<body>
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
                <div class="register_tab">
                    <h2>Enregistrement</h2>
                </div>
            </div>
            <form method="post">
                <div class="input_container">
                    <input type="text" class="inputText" name="name" placeholder="Mot de Passe">
                    <input type="text" class="inputText" name="firstname" placeholder="Mot de Passe">
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
</body>

</html>