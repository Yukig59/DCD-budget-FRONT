<?php

use CodeIgniter\I18n\Time;

?>
<?= $this->extend('navbar') ?>
<?= $this->section('content') ?>

<div id="modal-js-add" class="modal" xmlns="http://www.w3.org/1999/html">
    <div class="modal-background"></div>
    <div class="modal-content" style="overflow-y: hidden">
        <div class="box">
            <button class="modal-close is-large" aria-label="close"></button>
            <header class="modal-card-head">
                <p class="title is-3 has-text-centered has-text-dark"><strong>Ajouter une ligne de
                        budget</strong></p>
            </header>
            <div class="hero-body has-text-centered is-fullwidth" style="justify-content: center">
                <form action="<?= base_url("/budget-headers/add") ?>" method="post">

                    <div class="field ">
                        <label for="label" class="label">Label</label>
                        <div class="control has-icons-left">
                            <input type="text" class="input is-rounded" id="label" name="label"
                                   placeholder="MAINTENANCE EQUIPEMENTS">
                            <span class="icon is-small is-left">
                    <i class="fas fa-edit"></i>
                </span>
                        </div>
                    </div>
                    <div class="field">
                        <label for="numeroLigne" class="label">Numéro ligne</label>
                        <div class="control has-icons-left">
                            <input type="text" class="input is-rounded" id="numeroLigne" name="numeroLigne"
                                   placeholder="456852">
                            <span class="icon is-small is-left">
                    <i class="fas fa-info"></i>
                </span>
                        </div>
                    </div>
                    <div class="field">
                        <label for="type" class="label">Type de ligne</label>
                        <div class="control has-icons-left">
                            <div class="select is-rounded is-fullwidth">
                                <select name="type" id="type">
                                    <option value="Fonctionnement">Fonctionnement</option>
                                    <option value="Investissement">Investissement</option>
                                </select> <span class="icon is-small is-left">
                    <i class="fas fa-bookmark"></i>
                </span>
                            </div>

                        </div>
                    </div>
                    <div class="field">

                        <label for="budgetPrevisionnel" class="label">Budget Prévisionnel</label>
                        <div class="control has-icons-left">
                            <input type="text" class="input is-rounded" id="budgetPrevisionnel"
                                   name="budgetPrevisionnel" placeholder="500000"/>
                            <span class="icon is-small is-left">
                    <i class="fas fa-euro-sign"></i>
                </span>
                        </div>
                    </div>
                    <div class="field">
                        <label for="budgetReel" class="label">Budget Réel</label>
                        <div class="control has-icons-left">
                            <input type="text" class="input is-rounded" id="budgetReel" name="budgetReel"
                                   placeholder="500000"/>
                            <span class="icon is-small is-left">
                    <i class="fas fa-euro-sign"></i>
                </span>
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


<div class="columns is-centered ">
    <button class="js-modal-add button is-primary m-5" data-target="modal-js-add">
        <i class="fa fa-plus"></i>
        &nbsp; Créer une Ligne
    </button>
</div>
<?php if ($message !== null) { ?>
    <div class="container is-half">
        <div class="notification has-background-warning">
            <button class='delete'></button>
            <?= $message ?>
        </div>
    </div>
<?php } ?>
<?php if ($budgetHeaders) { ?>
    <div class="container">
        <div class="columns is-centered is-flex-wrap-wrap is-half-widescreen">
            <?php foreach ($budgetHeaders as $bh) { ?>
                <div class="column is-4">
                    <div class="card">
                        <header class="card-header">
                            <p class="card-header-title">
                                <?= $bh->label ?> (<?= $bh->type->label ?>)
                            </p>
                            <small>Code ligne: <?= $bh->number ?></small>
                            <button class="card-header-icon" aria-label="more options">
                            </button>
                        </header>
                        <div class="card-content">
                            <div class="content">
                                <div class="columns is-centered has-text-centered">
                                    <div class="column">
                                        <p>Budget Prévisionnel
                                            : <?= number_to_currency($bh->budgetPrevisionnel, 'EUR', 'fr_FR', 2); ?>

                                        </p>
                                        <p>Budget Réel
                                            : <?= number_to_currency($bh->budgetReel, 'EUR', 'fr_FR', 2) ?>
                                        </p>
                                    </div>
                                    <div class="column">
                                        <p>Budget Utilisé
                                            : <?= number_to_currency($bh->depenses, 'EUR', 'fr_FR', 2) ?>
                                        </p>
                                        <p>Budget Disponible
                                            : <?= number_to_currency($bh->budgetReel, 'EUR', 'fr_FR', 2) ?>
                                        </p>
                                        <p>
                                            Pourcentage Disponible
                                            <?= round($bh->budgetReel / $bh->budgetPrevisionnel * 100, 2) ?> %
                                        </p>
                                    </div>
                                </div>
                                <br>
                                <p>Ligne créée
                                    <time><?= Time::createFromTimestamp($bh->dateCreation)->humanize() ?></time>
                                </p>
                            </div>
                        </div>
                        <footer class="card-footer">
                            <a href="<?= base_url("budget-header/" . $bh->id) ?>"
                               class="card-footer-item"><i class="fa fa-info-circle"></i>&nbsp;
                                Détails</a>
                            <a href="<?= base_url('/budget-header/delete/' . $bh->id) ?>"
                               onclick="return confirm('Vous êtes sur le point de supprimer cette ligne de budget. Êtes-vous sur ?')"
                               class="card-footer-item"><i
                                        class="fa fa-trash-alt"></i>&nbsp;Supprimer</a>
                        </footer>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } else { ?>
    <div class="columns is-centered">
        <p>Aucune ligne de budget trouvée</p>

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

<?= $this->endsection('content') ?>
