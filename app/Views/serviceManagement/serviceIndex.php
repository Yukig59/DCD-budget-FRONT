<?php

use CodeIgniter\I18n\Time;

?>
<?= $this->extend('navbar') ?>
<?= $this->section('content') ?>

<head>
    <script src="<?= base_url("js/ServiceManagementFx.js") ?>"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            (document.querySelectorAll('.notification .delete') || []).forEach(($delete) => {
                const $notification = $delete.parentNode;

                $delete.addEventListener('click', () => {
                    $notification.parentNode.removeChild($notification);
                });
            });
        });
    </script>
</head>
<div class="container is-one-third mt-2">
    <div class="notification is-info has-text-centered">
        <button class='delete'></button>
        <p>Cliquez sur un des boutons ci-dessous pour afficher la page de configuration associée</p>
    </div>
</div>
<?php if ($message !== null) { ?>
    <div class="container is-half">
        <div class="notification has-background-warning">
            <button class='delete'></button>
            <?= $message ?>
        </div>
    </div>
<?php } ?>
<section class="info-tiles m-2">
    <div class="tile is-ancestor has-text-centered">
        <div class="tile is-parent">
            <a id="showMarket" href="javascript:show('market')" class="tile is-child box">
                <article>
                    <p class="title icon"><i class="fa fa-money-bill-alt"></i></p>
                    <p class="subtitle">Gestion des marchés publiques</p>
                </article>
            </a>
        </div>
        <div class="tile is-parent">
            <a id="showUser" href="javascript:show('user')" class="tile is-child box">

                <article>
                    <p class="title icon"><i class="fa fa-user-cog"></i></p>
                    <p class="subtitle">Gestion des utilisateurs</p>
                </article>
            </a>
        </div>
        <div class="tile is-parent">
            <a id="showFourn" href="javascript:show('fournisseur')" class="tile is-child box">

                <article>
                    <p class="title icon"><i class="fa fa-truck-loading"></i></p>
                    <p class="subtitle">Gestion des fournisseurs</p>
                </article>
            </a>
        </div>
    </div>
</section>
<section>
    <div id="market" style="display: none">
        <div class="columns is-centered ">
            <button class="js-modal-add button is-primary m-5" data-target="modal-js-add">
                <i class="fa fa-plus"></i>
                &nbsp; Ajouter un marché publique
            </button>
        </div>
        <div id="modal-js-add" class="modal">
            <div class="modal-background"></div>
            <div class="modal-content" style="overflow-y: hidden">
                <div class="box">
                    <button class="modal-close is-large" aria-label="close"></button>
                    <header class="modal-card-head">
                        <p class="title is-3 has-text-centered has-text-dark"><strong>Ajouter un marché
                                publique</strong>
                        </p>
                    </header>
                    <div class="hero-body has-text-centered is-fullwidth" style="justify-content: center">
                        <form action="<?= base_url('/market/add') ?>" method="post">
                            <div class="field ">
                                <label for="label" class="label">Label</label>
                                <div class="control has-icons-left">
                                    <input type="text" name="label" id="label"
                                           placeholder="FOURNITURES DE PETIT EQUIPEMENT" class="input is-rounded">
                                    <span class="icon is-small is-left">
                                        <i class="fas fa-edit"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="field">
                                <label for="numero" class="label">Numéro de marché</label>
                                <div class="control has-icons-left">
                                    <input type="text" name="numero" id="numero" class="input is-rounded"
                                           placeholder="451834">
                                    <span class="icon is-small is-left">
                                        <i class="fas fa-info"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="field">
                                <div class="control has-icons-left">
                                    <label for="typologie" class="label">Typologie du marché</label>
                                    <div class="select is-fullwidth is-rounded">

                                        <select name="typologie" id="typologie">
                                            <option value="Procédure adaptée">Procédure adaptée</option>
                                            <option value="Prestataire unique">Prestataire unique</option>
                                            <option value="Hors procédure">Hors procédure</option>
                                        </select>
                                        <span class="icon is-small is-left">
                                            <i class="fas fa-bookmark"></i>
                                        </span>
                                    </div>

                                </div>
                            </div>
                            <div class="field">
                                <label for="startDate" class="label">Date de début du marché</label>
                                <div class="control  has-icons-left">
                                    <div class="control is-fullwidth">
                                        <input type="date" name="startDate" id="startDate" class="input is-rounded">
                                    </div>
                                </div>
                            </div>
                            <div class="field">
                                <label for="endDate" class="label">Date de fin du marché</label>
                                <div class="control  has-icons-left">
                                    <div class="control is-fullwidth">
                                        <input type="date" name="endDate" id="endDate" class="input is-rounded">
                                    </div>
                                </div>
                            </div>
                            <div class="columns is-centered m-2">
                                <input type="submit" class="button is-primary is-rounded" value="Enregistrer"/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($markets) { ?>
            <div class="columns is-centered is-flex-wrap-wrap ml-2 mr-2">
                <?php foreach ($markets as $market) { ?>
                    <div class="column is-one-fifth">
                        <div class="card">
                            <header class="card-header">
                                <p class="card-header-title">
                                    <?= $market->label ?> &nbsp;
                                </p>
                                <small>Numéro marché: <?= $market->code ?></small>
                                <button class="card-header-icon" aria-label="more options">
                                </button>
                            </header>
                            <div class="card-content">
                                <div class="content">
                                    <div class="columns is-centered has-text-centered">
                                        <div class="column">
                                            <?= $market->type->label ?>
                                        </div>
                                        <div class="column">

                                        </div>
                                    </div>
                                    <br>Début du marché :

                                    <time><?= Time::createFromTimestamp($market->dateDebut)->toDateTimeString() ?></time>
                                    <br>
                                    Fin du marché
                                    <time><?= Time::createFromTimestamp($market->dateFin)->humanize() ?></time>
                                </div>
                            </div>
                            <footer class="card-footer">
                                <a class="card-footer-item" href="<?= base_url('/market/edit/' . $market->id) ?>"><i
                                            class="fa fa-info-circle"></i>&nbsp;
                                    Modifier</a>
                                <a href="<?= base_url('/market/delete/' . $market->id) ?>"
                                   onclick="return confirm('Vous êtes sur le point de supprimer ce marché publique. Êtes-vous sur ?')"
                                   class="card-footer-item"><i
                                            class="fa fa-trash-alt"></i>&nbsp;
                                    Supprimer</a>
                            </footer>

                        </div>
                    </div>

                <?php } ?>
            </div>
        <?php } else { ?>

            <div class="columns is-centered">
                <p>Aucun marché trouvé</p>
            </div>
        <?php } ?>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Functions to open and close a modal
                function openModal($el) {
                    $el.classList.add('is-active');
                }

                function closeModal($el) {
                    $el.classList.remove('is-active');
                }

                function closeAllModals() {
                    (document.querySelectorAll('.modal') || []).forEach(($modal) => {
                        closeModal($modal);
                    });
                }

                // Add a click event on buttons to open a specific modal
                (document.querySelectorAll('.js-modal-add') || []).forEach(($trigger) => {
                    const modal = $trigger.dataset.target;
                    const $target = document.getElementById(modal);
                    console.log($target);

                    $trigger.addEventListener('click', () => {
                        openModal($target);
                    });
                });
                (document.querySelectorAll('.modal-edit-market') || []).forEach(($trigger) => {
                    const modal = $trigger.dataset.target;
                    const $target = document.getElementById(modal);
                    console.log($target);

                    $trigger.addEventListener('click', () => {
                        openModal($target);
                    });
                });
                // Add a click event on various child elements to close the parent modal
                (document.querySelectorAll('.modal-background, .modal-close, .modal-card-head .delete, .modal-card-foot .button') || []).forEach(($close) => {
                    const $target = $close.closest('.modal');

                    $close.addEventListener('click', () => {
                        closeModal($target);
                    });
                });
                // Add a keyboard event to close all modals
                document.addEventListener('keydown', (event) => {
                    const e = event || window.event;

                    if (e.keyCode === 27) { // Escape key
                        closeAllModals();
                    }
                });
            });
            document.addEventListener('DOMContentLoaded', () => {
                (document.querySelectorAll('.notification .delete') || []).forEach(($delete) => {
                    const $notification = $delete.parentNode;

                    $delete.addEventListener('click', () => {
                        $notification.parentNode.removeChild($notification);
                    });
                });
            });
        </script>
    </div>
    <div id="user" style="display: none">

        <div class="columns is-centered is-flex-wrap-wrap ml-2 mr-2">
            <?php foreach ($users as $user) { ?>
                <div class="column is-one-fifth">
                    <div class="card">
                        <header class="card-header">
                            <p class="card-header-title">
                                <?= $user->nom . " " . $user->prenom ?>
                            </p>

                        </header>
                        <div class="card-content">
                            <div class="content">
                                <div class="columns ">
                                    <div class="column">
                                        <p>Email : <a href="mailto://<?= $user->email ?>"
                                                      title="Envoyer un mail à <?= $user->email ?>"><?= $user->email ?></a>
                                        </p>
                                    </div>
                                </div>
                                <br>Créé
                                <time><?= Time::createFromTimestamp($user->dateCreation)->humanize() ?></time>
                            </div>
                        </div>
                        <footer class="card-footer">
                            <a onclick="return confirm('Vous êtes sur le point de supprimer cet utilisateur. Êtes-vous sur ?')"
                               href="<?= base_url("/user/delete/" . $user->id) ?>" class="card-footer-item "><i
                                        class="fa fa-trash-alt"></i>&nbsp;
                                Révoquer l'acces à l'application</a>
                        </footer>
                    </div>
                </div>
            <?php } ?>
        </div>

    </div>
    <div id="fournisseur" style="display: none">
        <div class="columns is-centered ">
            <button class="modal-js-add-fourn button is-primary m-5" data-target="modal-js-add-fourn">
                <i class="fa fa-plus"></i>
                &nbsp; Ajouter un fournisseur
            </button>
        </div>
        <div id="modal-js-add-fourn" class="modal">
            <div class="modal-background"></div>
            <div class="modal-content" style="overflow-y: hidden">
                <div class="box">
                    <button class="modal-close is-large" aria-label="close"></button>
                    <header class="modal-card-head">
                        <p class="title is-3 has-text-centered has-text-dark"><strong>Ajouter un fournisseur</strong>
                        </p>
                    </header>
                    <div class="hero-body has-text-centered is-fullwidth" style="justify-content: center">
                        <form action="<?= base_url("/fournisseur/add") ?>" method="post">

                            <div class="hero-body has-text-centered is-fullwidth" style="justify-content: center">
                                <div class="field ">
                                    <label for="raisonSociale" class="label">Raison Sociale</label>
                                    <div class="control has-icons-left">
                                        <input type="text" name="raisonSociale" id="raisonSociale"
                                               class="input is-rounded is-fullwidth"
                                               placeholder="ex: LDLC">
                                        <span class="icon is-small is-left">
                                        <i class="fas fa-edit"></i>
                                    </span>
                                    </div>
                                </div>
                                <div class="field">
                                    <label for="siret" class="label">Siret</label>
                                    <div class="control has-icons-left">
                                        <input type="text" name="siret" id="siret" class="is-rounded input is-fullwidth"
                                               placeholder="838 651 594 00023">
                                        <span class="icon is-small is-left">
                                        <i class="fas fa-info"></i>
                                    </span>
                                    </div>
                                </div>
                                <div class="field">
                                    <label for="addr1" class="label">Adresse ligne 1</label>
                                    <div class="control has-icons-left">
                                        <input type="text" name="addr1" id="addr1" class="input is-rounded is-fullwidth"
                                               placeholder="10 Rue du général De Gaulle">
                                        <span class="icon is-small is-left">
                                <i class="fas fa-warehouse"></i>
                            </span>
                                    </div>
                                </div>
                                <div class="field">
                                    <label for="addr2" class="label">Adresse ligne 1</label>
                                    <div class="control has-icons-left">
                                        <input type="text" name="addr2" id="addr2" class="input is-rounded is-fullwidth"
                                               placeholder="Bat 5 / parking B">
                                        <span class="icon is-small is-left">
                                <i class="fas fa-warehouse"></i>
                            </span>
                                    </div>
                                </div>
                                <div class="field">
                                    <label for="zipcode" class="label">Code Postal</label>
                                    <div class="control  has-icons-left">
                                        <input type="number" name="zipcode" id="zipcode" placeholder="76600"
                                               class="input is-rounded is-fullwidth">
                                        <span class="icon is-small is-left">
                                <i class="fas fa-map-marked-alt"></i>
                            </span>
                                    </div>
                                </div>
                                <div class="field">
                                    <label for="city" class="label">Ville</label>
                                    <div class="control has-icons-left">
                                        <input type="text" name="city" id="city" placeholder="Le Havre"
                                               class="input is-rounded is-fullwidth">
                                        <span class="icon is-small is-left">
                                <i class="fas fa-map-marked-alt"></i>
                            </span>
                                    </div>
                                </div>
                                <div class="field">
                                    <label for="telephone" class="label">Telephone</label>
                                    <div class="control has-icons-left">
                                        <input type="text" name="telephone" id="telephone"
                                               class="input is-rounded is-fullwidth"
                                               placeholder="0254653214">
                                        <span class="icon is-small is-left">
                                <i class="fas fa-phone-alt"></i>
                            </span></div>
                                </div>
                                <div class="columns is-centered m-2">
                                    <input type="submit" class="button is-primary is-rounded" value="Enregistrer"/>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if (!empty($fournisseurs)) { ?>
        <div class="columns is-centered is-flex-wrap-wrap ml-2 mr-2">
            <?php foreach ($fournisseurs as $fournisseur) { ?>
                <div class="column is-one-fifth">
                    <div class="card">
                        <header class="card-header">
                            <p class="card-header-title">
                                <?= $fournisseur->raisonSociale ?>
                            </p>
                            <small>Numéro de siret: <?= $fournisseur->siret ?></small>
                            <button class="card-header-icon" aria-label="more options">
                            </button>
                        </header>
                        <div class="card-content">
                            <div class="content">
                                <div class="columns is-centered has-text-centered">
                                    <div class="column">
                                        <i class="fa fa-map-location-dot"></i> <?= $fournisseur->addressLine1 ?>
                                        <br>
                                        <?= $fournisseur->addressLine2 ?? '' ?><br>
                                        <?= $fournisseur->zipCode ?><br>
                                        <?= $fournisseur->city ?><br>
                                    </div>
                                    <div class="column">
                                        <i class="fa fa-phone-alt"></i>&nbsp;<?= $fournisseur->telephone ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <footer class="card-footer">
                            <a href="{{ path('show_fournisseur', {'fournisseurId':f.fournisseurId }) }}"
                               class="card-footer-item"><i class="fa fa-info-circle"></i>&nbsp;
                                Détails</a>
                            <a href="<?= base_url("/fournisseur/delete/" . $fournisseur->id) ?>"
                               onclick="return confirm('Vous êtes sur le point de supprimer ce fournisseur. Êtes-vous sur ?')"
                               class="card-footer-item"><i
                                        class="fa fa-trash-alt"></i>&nbsp;
                                Supprimer</a>
                        </footer>
                    </div>
                </div>

            <?php } ?>
        </div>
    <?php } else { ?>
        <div class="columns is-centered">
            <p>Aucun fournisseur trouvée</p>
        </div>
    <?php } ?>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Functions to open and close a modal
            function openModal($el) {
                $el.classList.add('is-active');
            }

            function closeModal($el) {
                $el.classList.remove('is-active');
            }

            function closeAllModals() {
                (document.querySelectorAll('.modal') || []).forEach(($modal) => {
                    closeModal($modal);
                });
            }

            // Add a click event on buttons to open a specific modal
            (document.querySelectorAll('.modal-js-add-fourn') || []).forEach(($trigger) => {
                const modal = $trigger.dataset.target;
                const $target = document.getElementById(modal);
                console.log($target);
                $trigger.addEventListener('click', () => {
                    openModal($target);
                });
            });
            // Add a click event on various child elements to close the parent modal
            (document.querySelectorAll('.modal-background, .modal-close, .modal-card-head .delete, .modal-card-foot .button') || []).forEach(($close) => {
                const $target = $close.closest('.modal');
                $close.addEventListener('click', () => {
                    closeModal($target);
                });
            });
            // Add a keyboard event to close all modals
            document.addEventListener('keydown', (event) => {
                const e = event || window.event;
                if (e.keyCode === 27) { // Escape key
                    closeAllModals();
                }
            });
        });
        document.addEventListener('DOMContentLoaded', () => {
            (document.querySelectorAll('.notification .delete') || []).forEach(($delete) => {
                const $notification = $delete.parentNode;
                $delete.addEventListener('click', () => {
                    $notification.parentNode.removeChild($notification);
                });
            });
        });
    </script>
    </div>
    </div>


</section>

<?= $this->endSection('content') ?>
