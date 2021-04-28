<?php ob_start(); ?>

<main>
    <header>
        <div class="header_top">
            <img id="left-side_icon" src="..\..\assets\icons\left-arrow.png" class="previousPage" onclick="document.location.href='<?= $this->goBack() ?>'">
        </div>

        <div class="header_bottom">
            <h1>Social</h1>
        </div>
    </header>

    <div class="wrapper">
        <section>
            <form method="POST" class="addToken_form">
                <h1>Saisissez le token de la Todo</h1>

                <div class="tokenInput_container">
                    <input type="text" class="code" id="1" maxlength="1" placeholder="_" autocomplete="off">
                    <input type="text" class="code" id="2" maxlength="1" placeholder="_" autocomplete="off">
                    <input type="text" class="code" id="3" maxlength="1" placeholder="_" autocomplete="off">
                    <input type="text" class="code" id="4" maxlength="1" placeholder="_" autocomplete="off">
                    <input type="text" class="code" id="5" maxlength="1" placeholder="_" autocomplete="off">
                </div>

            </form>
        </section>

        <section>
            <div class="section_title">
                <h2>Demandes en attentes</h2>
            </div>

            <div class="invitation_wrapper">

                <?php foreach($list_pendingContribute as $pendingContribute){ ?>
                <div class="invitation_container">
                    <div class="invitation_icon">
                        <img src="..\..\assets\icons\unvalidate.png" alt="">
                    </div>
                    <div class="invitation_content">
                        <div class="invitation_user-info">
                            <p><?= $pendingContribute->getTodoOwnerName(); ?></p>
                            <h6><?= $pendingContribute->getTodoTitle(); ?></h6>
                        </div>
                        <p><?= $pendingContribute->getJoinDate(); ?></p>
                    </div>
                    <div class="invitation_button">
                        <img src="..\..\assets\icons\cancel.png" alt="">
                    </div>
                </div>
                <?php } ?>
            </div>
        </section>
    </div>
</main>


<script src="../module/social/tokenInput/inputManager.js"></script>
<script src="../module/social/tokenVerif/tokenVerif.js"></script>

<?php $this->content = ob_get_clean(); ?>