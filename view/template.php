<html lang="fr" dir="ltr">

<?= $controller->head(); ?>

<body onload="showMessageBox()">
    <?php if ($controller->getMessageBox() != null) {
        include("../view/messageBox/information.php");
    } ?>

    <?= $controller->getContent(); ?>

    <?php include_once("menu.php"); ?>
</body>


</html>