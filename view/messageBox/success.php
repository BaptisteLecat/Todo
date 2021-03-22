<?php ob_start(); ?>
<div class="messageBox_container" style="background-color: #3E7251; border-color: #2A5132;" id="messageBox_container" onclick="hideMessageBox()">
    <div class="icon_container">
        <img src="<?= '..\..\assets\icons\messageBox\\' . $this->getIcon() . '.png'; ?>">
    </div>
    <div class="text_container">
        <h6><?= $this->getTitle(); ?></h6>
        <p><?= $this->getMessage(); ?></p>
    </div>
</div>

<?php $messageHTML = ob_get_clean(); ?>