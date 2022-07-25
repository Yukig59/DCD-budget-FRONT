<?php

use CodeIgniter\I18n\Time;

?>
<?= $this->extend('navbar') ?>
<?= $this->section('content') ?>

    <div id="modal-js-add" class="modal">
        <div class="modal-background"></div>
        <div class="modal-content">
            <div class="box">
                <button class="modal-close is-large" aria-label="close"></button>
                <header class="modal-card-head">
                    <p class="title is-3 has-text-centered has-text-dark"><strong>Ajouter un bon de commande</strong>
                    </p>
                </header>
                <div class="hero-body has-text-centered is-fullwidth" style="justify-content: center">
                    <form method="post" action="<?= base_url("/purchase-order/add") ?>">
                        <div class="field ">
                            <label for="imputation" class="label">Imputation budgétaire</label>
                            <div class="control has-icons-left">
                                <input type="number" class="input is-rounded" placeholder="ex: 816" name="imputation"
                                       id="imputation">
                                <span class="icon is-small is-left">
                                    <i class="fas fa-edit"></i>
                                </span>
                            </div>
                        </div>
                        <div class="field">
                            <label for="label" class="label">Label</label>
                            <div class="control has-icons-left">
                                <input type="text" name="label" id="label" placeholder="ex: 3 souris sans fil"
                                       class="input is-rounded"/>
                                <span class="icon is-small is-left">
                                    <i class="fas fa-warehouse"></i>
                                </span>
                            </div>
                        </div>
                        <div class="field">
                            <label for="montant" class="label">Montant du bon</label>
                            <div class="control has-icons-left">
                                <input type="text" class="input is-rounded" name="montant" id="montant"
                                       placeholder="ex: 55.99">
                                <span class="icon is-small is-left">
                                    <i class="fas fa-euro"></i>
                                </span>
                            </div>
                        </div>
                        <div class="field">
                            <label for="number" class="label">N° de bon de commande</label>
                            <div class="control has-icons-left">
                                <input type="text" class="input is-rounded" name="number" id="number"
                                       placeholder="ex: 75596">
                                <span class="icon is-small is-left">
                                    <i class="fas fa-info"></i>
                                </span>
                            </div>
                        </div>
                        <div class="field">
                            <label for="marcheId" class="label">Marché</label>
                            <div class="control has-icons-left">
                                <div class="select is-fullwidth is-rounded">
                                    <select name="marcheId" id="marcheId">
                                        <?php foreach ($marches as $marche) { ?>
                                            <option value="<?= $marche->id ?>"><?= $marche->label ?></option>
                                        <?php } ?>
                                    </select>
                                    <span class="icon is-small is-left">
                                        <i class="fas fa-hard-hat"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <label for="type" class="label">Type</label>
                            <div class="control has-icons-left">
                                <div class="select is-fullwidth is-rounded">
                                    <select name="type" id="type">
                                        <option value="Fonctionnement">Fonctionnement</option>
                                        <option value="Investissement">Investissement</option>
                                    </select>
                                    <span class="icon is-small is-left">
                                        <i class="fas fa-info-circle"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <label for="emetteurId" class="label">Emetteur du bon</label>
                            <div class="control has-icons-left">
                                <div class="select is-fullwidth is-rounded">
                                    <select name="emetteurId" id="emetteurId">
                                        <?php foreach ($users as $user) { ?>
                                            <option value="<?= $user->id ?>"><?= $user->prenom . " " . strtoupper($user->nom) ?></option>
                                        <?php } ?>
                                    </select>
                                    <span class="icon is-small is-left">
                                        <i class="fas fa-user"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <label for="fournisseurId" class="label">Fournisseur</label>
                            <div class="control has-icons-left">
                                <div class="select is-fullwidth is-rounded">
                                    <select name="fournisseurId" id="fournisseurId">
                                        <?php foreach ($fournisseurs as $fournisseur) { ?>
                                            <option value="<?= $fournisseur->id ?>"><?= $fournisseur->raisonSociale ?></option>
                                        <?php } ?>
                                    </select>
                                    <span class="icon is-small is-left">
                                        <i class="fas fa-truck-droplet"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <label for="bhId" class="label">Ligne de budget</label>
                            <div class="control has-icons-left">
                                <div class="select is-fullwidth is-rounded">
                                    <select name="bhId" id="bhId">
                                        <?php foreach ($budgetHeaders as $bh) { ?>
                                            <option value="<?= $bh->id ?>"><?= $bh->label . " (n° " . $bh->number . ")" ?></option>
                                        <?php } ?>
                                    </select>
                                    <span class="icon is-small is-left">
                                        <i class="fas fa-money-bill-1-wave"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <label for="validateurId" class="label">Validateur du bon</label>
                            <div class="control has-icons-left">
                                <div class="select is-fullwidth is-rounded">
                                    <select name="validateurId" id="validateurId">
                                        <option value="<?= null ?>" selected>Non validé</option>
                                        <?php foreach ($users as $user) { ?>
                                            <option value="<?= $user->id ?>"><?= $user->prenom . " " . strtoupper($user->nom) ?></option>
                                        <?php } ?>
                                    </select>
                                    <span class="icon is-small is-left">
                                        <i class="fas fa-user"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <label for="commentaire">Commentaire (facultatif)</label>
                            <div class="control ">
                                <textarea class="textarea" name="commentaire" id="commentaire" cols="30"
                                          rows="5"></textarea>
                            </div>
                        </div>
                        <div class="field columns is-centered mt-5">

                            <div class="file">
                                <label class="file-label" for="facture">
                                    <input class="file-input" type="file" name="facture" id="facture">
                                    <span class="file-cta">
                                      <span class="file-icon">
                                        <i class="fas fa-paperclip"></i>
                                      </span>
                                      <span class="file-label">
                                        Joindre une facture
                                      </span>
                                    </span>
                                </label>
                            </div>
                        </div>
                        <div class="columns is-centered m-2">
                            <input type="submit" class="button is-primary is-rounded" value="Enregistrer"/>
                        </div>
                </div>
            </div>

            </form>
        </div>
    </div>

    <div class="columns is-centered ">
        <button class="js-modal-add button is-primary m-5" data-target="modal-js-add">
            <i class="fa fa-plus"></i>
            &nbsp; Créer un bon de commande
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
<?php if ($purchaseOrders) { ?>
    <div class="columns is-centered is-flex-wrap-wrap ml-2 mr-2">
        <?php foreach ($purchaseOrders as $po) { ?>
            <div class="column is-one-fifth">
                <div class="card">
                    <header class="card-header">
                        <p class="card-header-title">
                            <?= $po->label ?> <br>
                            <?= " Ligne n°" . $po->budgetHeader->id ?>
                        </p>

                        <button class="card-header-icon" aria-label="more options">
                        </button>
                    </header>
                    <div class="card-content">
                        <div class="content">
                            <p>N° de bon de commande: <?= $po->number ?></p>
                            <p> Imputation: <?= $po->imputation ?></p>
                            <div class="columns is-centered has-text-centered">
                                <div class="column">
                                    <p>Montant : <?= number_to_currency($po->montant, 'EUR', 'fr_FR', 2); ?>
                                    </p>
                                </div>
                                <div class="column">

                                </div>
                            </div>
                            <br>Créé
                            <time><?= Time::createFromTimestamp($po->dateCreation)->humanize() ?></time>

                        </div>
                    </div>
                    <footer class="card-footer">
                        <a href="<?= base_url('/purchase-order/edit/' . $po->id) ?>"
                           class="card-footer-item modal-js-edit"><i class="fa fa-info-circle"></i>&nbsp;
                            Modifier</a>
                        <a href="<?= base_url('purchase-order/delete/' . $po->id) ?>"
                           onclick="return confirm('Vous êtes sur le point de supprimer ce bon de commande. Êtes-vous sur ?')"
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
        <p>Aucun bon de commande trouvé</p>
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
            (document.querySelectorAll('.modal-js-edit') || []).forEach(($trigger) => {
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
<?= $this->endSection('content') ?>