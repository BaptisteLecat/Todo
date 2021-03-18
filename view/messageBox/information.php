<?php ob_start(); ?>
<div class="icon_container">
    <img src="<?= '..\..\assets\icons\messageBox\\' . $this->getIcon() . '.png'; ?>">
</div>
<div class="text_container">
    <h6><?= $errorMessage; ?></h6>
</div>

<?php $messageHTML = ob_get_clean(); ?>