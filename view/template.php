<html lang="fr" dir="ltr">

<?= $controller->head(); ?>

<body>

    <?php
    if ($controller->getMessageBox() != null) {
        echo($controller->getMessageBox());
        echo("<script>showMessageBox()</script>");
    } ?>


    <?= $controller->getContent(); ?>
</body>


</html>