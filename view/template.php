<html lang="fr" dir="ltr">

<?= $controller->head(); ?>

<body>

    <div class="messageBox_container" id="messageBox_container" onclick="hideMessageBox()">

        <?php
        if ($controller->getMessageBox() != null) {
            include("../view/messageBox/information.php");
        } ?>
    </div>


    <?= $controller->getContent(); ?>

</body>


</html>