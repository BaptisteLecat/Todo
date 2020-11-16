<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="POST">
        <input type="text" name="email" placeholder="email">
        <input type="submit" name="sender">
    </form>
    <footer>
        <?php if(isset($error["type"])){?>
            <h6><?= $error["message"] ?></h6>
        <?php } ?>
    </footer>
</body>
</html>