<?php ob_start(); ?>

<main>
<header>
        <div class="header_top">
            <img id="left-side_icon" src="..\..\assets\icons\left-arrow.png" class="previousPage" onclick="document.location.href='<?= $this->goBack() ?>'">
        </div>

        <div class="header_bottom">
            <h1>Compte</h1>
        </div>
    </header>

    <section>
        <button onclick="document.location.href='account/disconnect'">Se déconnecter</button>
    </section>

</main>
<?php $this->content = ob_get_clean(); ?>