<div class="box_container" id="box_container" onclick = "hideMessageBox()">
    <div class="icon_container">
        <img src="<?= '..\..\assets\icons\messageBox\\'. $controller->getMessageBox()->getIcon().'.png'; ?>">
    </div>
    <div class="text_container">
        <h6><?= $controller->getMessageBox()->getMessage(); ?></h6>
    </div>
</div>