<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php if ($etape == 1) { ?>
        <form action="" method="post">
            <input type="hidden" name="etape" value=1>
            <input type="text" name="email" placeholder="Email">
            <input type="submit" name="sender">
        </form>
    <?php } ?>
    <?php if ($etape == 2) { ?>
        <form action="" method="post">
            <input type="hidden" name="etape" value=2>
            <input type="text" minlength="6" maxlength="6" name="token" placeholder="Token">
            <input type="submit" name="sender">
        <?php } ?>
        </form>
    <footer>
        <?php if(isset($error["message"])){?>
            <h6><?= $error["message"] ?></h6>
        <?php } ?>
    </footer>
</body>
</html>