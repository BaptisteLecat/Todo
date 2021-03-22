<?php ob_start(); ?>
<div class="messageBox_container" style="background-color: #F25F5C; border-color: #A13836;" id="messageBox_container" onclick="hideMessageBox()">
    <div class="icon_container">
        <img src="<?= '..\..\assets\icons\messageBox\\' . $this->getIcon() . '.png'; ?>">
    </div>
    <div class="text_container">
        <p><?= $this->getMessage(); ?></p>
    </div>
</div>

<?php $messageHTML = ob_get_clean(); ?>