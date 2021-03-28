<?php ob_start(); ?>

<main>
    <header>
        <div class="header_top">
            <img id="left-side_icon" src="..\..\assets\icons\left-arrow.png" class="previousPage" onclick="document.location.href='<?= $this->goBack() ?>'">
        </div>

        <div class="header_bottom">
            <h1>Informations</h1>
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
                        <img src="" alt="">
                        <img src="" alt="">
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
                        <img src="" alt="">
                    </div>
                    <div class="invitation_content">
                        <h6>A6E8RM</h6>
                        <p>19-02-2020</p>
                    </div>
                    <div class="invitation_button">
                        <img src="" alt="">
                        <img src="" alt="">
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>

<?php $this->content = ob_get_clean(); ?>