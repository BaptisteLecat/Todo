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

            <form method="POST">
                <h6>Nom de la Todo</h6>
                <input type="text" name="todoName" value="<?= $todo->getTitle() ?>">

                <h6>Description</h6>
                <textarea name="todoDescription" cols="30" rows="10"><?= $todo->getDescription() ?></textarea>

                <div class="formSubmit">
                    <button>Modifier</button>
                </div>
            </form>
        </section>

        <section>
            <div class="section_title">
                <h2>Participants</h2>
            </div>

            <div class="participant_wrapper">
                <?php foreach ($list_userContributor as $userContributor) { ?>
                    <div class="participant_container">

                        <div class="participant-content_wrapper">
                            <div class="participant-icon_container">
                                <img src="..\..\assets\icons\validate.png" alt="">
                            </div>
                            <div class="participant-content_container">
                                <div class="user-info">
                                    <p><?= $userContributor->getName(); ?></p>
                                    <h5><?= $userContributor->getFirstName(); ?></h5>
                                </div>
                                <h6><?= $userContributor->getJoinDate(); ?><h6>
                            </div>
                            <div class="participant-develop_container">
                                <img src="..\..\assets\icons\bottom-chevron.png" alt="">
                            </div>
                        </div>

                        <div class="participant-info_container">
                            <ul>
                                <li>
                                    <img src="..\..\assets\icons\mail-inbox.png" alt="">
                                    <p><?= $userContributor->getEmail(); ?></p>
                                </li>
                            </ul>

                            <div class="permission_container">
                                <h6>Gestion des droits</h6>
                                <ul>
                                    <?php foreach ($this->list_permission as $permission) { ?>
                                        <li>
                                            <?php if ($userContributor->havePermission($permission)) { ?>
                                                <input type="checkbox" id="<?= $permission->getId() ?>" checked>
                                            <?php } else { ?>
                                                <input type="checkbox" id="<?= $permission->getId() ?>">
                                            <?php } ?>
                                            <p><?= utf8_encode($permission->getContent()); ?></p>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </section>
    </div>

</main>

<script src="../../js/settings/informations/formUpdate.js"></script>
<script src="../../js/settings/informations/participantManager.js"></script>

<?php $this->content = ob_get_clean(); ?>