<html lang="fr" dir="ltr">

<?= $controller->head(); ?>

<body>

    <?php
    if ($controller->getMessageBox() != null) {
        include("../view/messageBox/error.php");
        include("../view/messageBox/success.php");
    } ?>


    <?= $controller->getContent(); ?>
</body>


</html>