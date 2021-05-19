<html lang="fr" dir="ltr">

<?= $controller->head(); ?>

<body>
    <?= $controller->getContent(); ?>
</body>

<?php
if ($controller->getMessageBox() != null) {
    echo ($controller->getMessageBox());
    echo ("<script>showMessageBox()</script>");
} ?>

</html>