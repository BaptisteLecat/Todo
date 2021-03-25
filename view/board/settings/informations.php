<?php ob_start(); ?>

<main>
    <header>
        <div class="header_top">
            <img id="left-side_icon" src="..\..\assets\icons\left-arrow.png" class="previousPage" onclick="document.location.href='board'">
        </div>

        <div class="header_bottom">
            <h1>Informations</h1>
        </div>
    </header>

    <div class="wrapper">

        <section>
            <div class="section_title">
                <h2>Détails</h2>
            </div>

            <form>
                <h6>Nom de la Todo</h6>
                <input type="text" name="todoName" value="<?= $todo->getTitle() ?>">

                <h6>Description</h6>
                <textarea name="todoDescription" cols="30" rows="10"><?= $todo->getDescription() ?></textarea>
            </form>
        </section>

        <section>
            <div class="section_title">
                <h2>Participants</h2>
            </div>

            <div class="participant_wrapper">
                <div class="participant_container">

                    <div class="participant-content_wrapper">
                        <div class="participant-icon_container">
                            <img src="..\..\assets\icons\validate.png" alt="">
                        </div>
                        <div class="participant-content_container">
                            <div class="user-info">
                                <p>Lecat</p>
                                <h5>Baptiste</h5>
                            </div>
                            <h6>19-02-2020<h6>
                        </div>
                        <div class="participant-develop_container">
                            <img src="..\..\assets\icons\bottom-chevron.png" alt="">
                        </div>
                    </div>

                    <div class="participant-info_container">
                        <ul>
                            <li>
                                <img src="..\..\assets\icons\mail-inbox.png" alt="">
                                <p>baptiste.lecat44@gmail.com</p>
                            </li>
                        </ul>

                        <div class="permission_container">
                            <h6>Gestion des droits</h6>
                            <ul>
                                <li>
                                    <div class="checkBox"></div>
                                    <p>Réaliser une tâche</p>
                                </li>
                                <li>
                                    <div class="checkBox"></div>
                                    <p>Réaliser une tâche</p>
                                </li>
                                <li>
                                    <div class="checkBox"></div>
                                    <p>Réaliser une tâche</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

</main>

<?php $this->content = ob_get_clean(); ?>