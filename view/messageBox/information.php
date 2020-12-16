<div class="box_container" id="box_container" onclick = "hideMessageBox()">
    <div class="icon_container">
        <img src="<?= '..\..\assets\icons\messageBox\\'.$messageBox->getIcon().'.png'; ?>" alt="">
    </div>
    <div class="text_container">
        <h6><?= $messageBox->getMessage(); ?></h6>
    </div>
</div>