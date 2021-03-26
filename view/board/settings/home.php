<?php ob_start(); ?>

<main>

    <header>
        <div class="header_top">
            <img id="left-side_icon" src="..\..\assets\icons\left-arrow.png" class="previousPage" onclick="document.location.href='<?= $_SERVER['REQUEST_URI'] . '/..' ?>'">
        </div>

        <div class="header_bottom">
            <h1>Paramètres</h1>
        </div>
    </header>

    <div class="wrapper">
        <div class="notice_container">
            <div class="stat_container">
            </div>
            <div class="content_container">
                <h3>Félicitation !</h3>
                <p>Vous avez validé plus de la moitié des tâches de votre Todo !</p>
            </div>
        </div>

        <section>
            <div class="menu-item_container" onclick="document.location.href ='<?= $_SERVER['REQUEST_URI'] . '/informations' ?>'">
                <div class="item-icon_container">
                    <div class="icon_box">
                        <img src="..\..\assets\icons\settings\information.png" alt="">
                    </div>
                </div>
                <div class="item-content_container">
                    <div class="item-content">
                        <h2>Informations</h2>
                        <h6>Gestions des informations</h6>
                    </div>
                    <div class="item-link_container">
                        <img src="..\..\assets\icons\right-chevron.png" alt="">
                    </div>
                </div>
            </div>

            <div class="menu-item_container" onclick="document.location.href ='<?= $_SERVER['REQUEST_URI'] . '/invitations' ?>'">
                <div class="item-icon_container">
                    <div class="icon_box">
                        <img src="..\..\assets\icons\settings\invite.png" alt="">
                    </div>
                </div>
                <div class="item-content_container">
                    <div class="item-content">
                        <h2>Invitations</h2>
                        <h6>Gestions des invitations</h6>
                    </div>
                    <div class="item-link_container">
                        <img src="..\..\assets\icons\right-chevron.png" alt="">
                    </div>
                </div>
            </div>

            <div class="menu-item_container" onclick="document.location.href ='<?= $_SERVER['REQUEST_URI'] . '/archives' ?>'">
                <div class="item-icon_container">
                    <div class="icon_box">
                        <img src="..\..\assets\icons\settings\archive.png" alt="">
                    </div>
                </div>
                <div class="item-content_container">
                    <div class="item-content">
                        <h2>Archives</h2>
                        <h6>Gestions des archives</h6>
                    </div>
                    <div class="item-link_container">
                        <img src="..\..\assets\icons\right-chevron.png" alt="">
                    </div>
                </div>
            </div>
        </section>

        <div class="leave-todo_container">
            <button>Quitter la Todo</button>
        </div>
    </div>

</main>

<?php $this->content = ob_get_clean(); ?>