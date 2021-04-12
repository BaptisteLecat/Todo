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

                <div class="token_container">
                    <div class="token_content">
                        <h6>A6E8RM</h6>
                        <p>19-02-2020</p>
                    </div>
                    <div class="token_button">
                        <img src="..\..\assets\icons\refresh.png" alt="">
                        <img src="..\..\assets\icons\trash.png" alt="">
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="section_title">
                <h2>Demandes en attentes</h2>
            </div>

            <div class="invitation_wrapper">

                <div class="invitation_container">
                    <div class="invitation_icon">
                        <img src="..\..\assets\icons\unvalidate.png" alt="">
                    </div>
                    <div class="invitation_content">
                        <div class="invitation_user-info">
                            <p>Lecat</p>
                            <h6>Baptiste</h6>
                        </div>
                        <p>25-03-2020</p>
                    </div>
                    <div class="invitation_button">
                        <img src="..\..\assets\icons\accept.png" alt="">
                        <img src="..\..\assets\icons\cancel.png" alt="">
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>

<?php $this->content = ob_get_clean(); ?>