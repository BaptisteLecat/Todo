<?php ob_start(); ?>

<main>
    <header>
        <div class="header_top">
            <img id="left-side_icon" src="..\..\assets\icons\left-arrow.png" class="previousPage" onclick="document.location.href='<?= $this->goBack() ?>'">
            <button>Générer</button>
        </div>

        <div class="header_bottom">
            <h1>Invitations</h1>
        </div>
    </header>

    <div class="wrapper">
        <section>
            <div class="section_title">
                <h2>Vos Tokens</h2>
            </div>

            <div class="token_wrapper">
                <?php
                foreach ($todo->getList_TodoToken() as $token) { ?>
                    <div class="token_container">
                        <div class="token_content">
                            <h6><?= $token->getToken(); ?></h6>
                            <p><?= $token->getExpirationDate(); ?></p>
                        </div>
                        <div class="token_button">
                            <img src="..\..\assets\icons\refresh.png" alt="">
                            <img src="..\..\assets\icons\trash.png" alt="">
                        </div>
                    </div>
                <?php } ?>
            </div>
        </section>

        <section>
            <div class="section_title">
                <h2>Demandes en attentes</h2>
            </div>

            <div class="invitation_wrapper">

                <?php

                foreach ($list_userContributor as $contributor) {
                    if (!$contributor->getAccepted()) { ?>

                        <div class="invitation_container">
                            <div class="invitation_icon">
                                <img src="..\..\assets\icons\unvalidate.png" alt="">
                            </div>
                            <div class="invitation_content">
                                <div class="invitation_user-info">
                                    <p><?= $contributor->getName(); ?></p>
                                    <h6><?= $contributor->getFirstName(); ?></h6>
                                </div>
                                <p><?php $contributor->getJoinDate(); ?></p>
                            </div>
                            <div class="invitation_button">
                                <img src="..\..\assets\icons\accept.png" alt="">
                                <img src="..\..\assets\icons\cancel.png" alt="">
                            </div>
                        </div>

                <?php }
                }
                ?>
            </div>
        </section>
    </div>
</main>

<?php $this->content = ob_get_clean(); ?>