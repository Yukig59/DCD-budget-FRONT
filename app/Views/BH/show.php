<?php

use CodeIgniter\I18n\Time;

?>
<?= $this->extend('navbar') ?>
<?= $this->section('content') ?>
<head>
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/v/bm/jq-3.6.0/dt-1.12.1/b-2.2.3/b-html5-2.2.3/datatables.min.css"/>

    <script type="text/javascript"
            src="https://cdn.datatables.net/v/bm/jq-3.6.0/dt-1.12.1/b-2.2.3/b-html5-2.2.3/datatables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#example').DataTable();
        });
    </script>
    <!--
    *   Google Chart configuration
    -->
    <!--Load the AJAX API-->
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
        // Load the Visualization API and the corechart package.
        google.charts.load('current', {'packages': ['corechart']});

        // Set a callback to run when the Google Visualization API is loaded.
        google.charts.setOnLoadCallback(drawChart);

        // Callback that creates and populates a data table,
        // instantiates the pie chart, passes in the data and
        // draws it.
        function drawChart() {

            // Create the data table.
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Utilisé');
            data.addColumn('number', 'Restant');
            data.addRows([
                ['Utilisé', <?= $bh->depenses ?>],
                ['Restant', <?= $bh->budgetReel ?>],

            ]);

            // Set chart options
            var options = {
                'title': 'Utilisation de la ligne',
                'width': 500,
                'height': 400,
                'colors': ['red', 'green'],
                'legend': {position: 'middle', alignment: 'center'},
                'titleTextStyle': {position: 'top', alignment: "center"}
            };

            // Instantiate and draw our chart, passing in some options.
            var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }
    </script>
</head>
<!--Modal Modifier les en-têtes-->
<div id="js-modal-edit-headers" class="modal" xmlns="http://www.w3.org/1999/html">
    <div class="modal-background"></div>
    <div class="modal-content" style="overflow-y: hidden">
        <div class="box">
            <button class="modal-close is-large" aria-label="close"></button>
            <header class="modal-card-head">
                <p class="title is-3 has-text-centered has-text-dark"><strong>Modifier les en-têtes de la ligne</strong>
                </p>
            </header>
            <div class="hero-body has-text-centered is-fullwidth" style="justify-content: center">
                <form action="<?= base_url("/budget-headers/updateHeaders") ?>" method="post">

                    <div class="field ">
                        <label for="label" class="label">Label</label>
                        <div class="control has-icons-left">
                            <input type="text" class="input is-rounded" id="label" name="label"
                                   value="<?= $bh->label ?>">
                            <span class="icon is-small is-left">
                                <i class="fas fa-edit"></i>
                            </span>
                        </div>
                    </div>
                    <div class="field">
                        <label for="numeroLigne" class="label">Numéro ligne</label>
                        <div class="control has-icons-left">
                            <input type="text" class="input is-rounded" id="numeroLigne" name="numeroLigne"
                                   value="<?= $bh->number ?>">
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
                                    <option value="Fonctionnement"
                                            <?php if ($bh->type->label == "Fonctionnement"){ ?>selected<?php } ?> >
                                        Fonctionnement
                                    </option>
                                    <option value="Investissement"
                                            <?php if ($bh->type->label == "Investissement"){ ?>selected<?php } ?>>
                                        Investissement
                                    </option>
                                </select>
                                <span class="icon is-small is-left">
                                    <i class="fas fa-bookmark"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" value="<?= $bh->id ?>" name="id">
                    <div class="columns is-centered m-2">
                        <input type="submit" class="button is-primary is-rounded" value="Enregistrer"/>
                    </div>
                </form>
            </div>
        </div>


    </div>
</div>
<!--Modal Faire un virement-->
<div id="js-modal-do-virement" class="modal" xmlns="http://www.w3.org/1999/html">
    <div class="modal-background"></div>
    <div class="modal-content" style="overflow-y: hidden">
        <div class="box">
            <button class="modal-close is-large" aria-label="close"></button>
            <header class="modal-card-head">
                <p class="title is-3 has-text-centered has-text-dark"><strong>Faire un virement de crédits</strong>
                </p>
            </header>
            <div class="hero-body has-text-centered is-fullwidth" style="justify-content: center">

                <form action="<?= base_url("/budget-headers/transfer") ?>" method="post">

                    <div class="field">
                        <label for="fromBhId" class="label">Ligne de budget à prélever</label>
                        <div class="control has-icons-left">
                            <div class="select is-fullwidth is-rounded">
                                <select name="fromBhId" id="fromBhId">
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
                        <label for="toBhId" class="label">Ligne de budget à créditer</label>
                        <div class="control has-icons-left">
                            <div class="select is-fullwidth is-rounded">
                                <select name="toBhId" id="toBhId">
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

                        <label for="montant" class="label">Montant à créditer</label>
                        <div class="control has-icons-left">
                            <input type="text" class="input is-rounded" id="montant" name="montant"
                                   placeholder="500">
                            <span class="icon is-small is-left">
                                <i class="fas fa-euro"></i>
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
<!--Modal demander un virement-->
<div id="js-modal-ask-credit" class="modal" xmlns="http://www.w3.org/1999/html">
    <div class="modal-background"></div>
    <div class="modal-content" style="overflow-y: hidden">
        <div class="box">
            <button class="modal-close is-large" aria-label="close"></button>
            <header class="modal-card-head">
                <p class="title is-3 has-text-centered has-text-dark"><strong>Demander un virement de crédits</strong>
                </p>
            </header>
            <div class="hero-body has-text-centered is-fullwidth" style="justify-content: center">
                <form action="<?= base_url("/budget-headers/ask-credit") ?>" method="post">

                    <div class="field">
                        <label for="bhId" class="label">Ligne de budget à créditer</label>
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
                        <label for="userIdToNotify" class="label">Faire la demande à :</label>
                        <div class="control has-icons-left">
                            <div class="select is-fullwidth is-rounded">
                                <select name="userIdToNotify" id="userIdToNotify">
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

                        <label for="montant" class="label">Montant à de la demande</label>
                        <div class="control has-icons-left">
                            <input type="text" class="input is-rounded" id="montant" name="montant"
                                   placeholder="500">
                            <span class="icon is-small is-left">
                                <i class="fas fa-euro"></i>
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

</div>

<div class="card column is-fullwidth is-vcentered m-5">
    <header class="card-header">
        <p class="card-header-title">
            <?= $bh->label . " | N° " . $bh->number . " (Type : " . $bh->type->label . ")" ?>
        </p>
        <a class="card-header-icon" href="#">
            <span class="icon">
                        <i class="fas fa-pie-chart" aria-hidden="true"></i>
                    </span>
        </a>
    </header>
    <div class="card-content columns is-narrow">
        <div class="content column is-one-third">

            <strong>Budget prévisionnel :</strong>
            <?= number_to_currency($bh->budgetPrevisionnel, 'EUR', 'fr_FR', 2); ?>
            <br>
            <strong>Budget Réel :</strong>
            <?php if ($bh->budgetReel > $bh->budgetPrevisionnel * 0.5) { ?>
                <span class="has-text-success">
                    <?= number_to_currency($bh->budgetReel, 'EUR', 'fr_FR', 2); ?>
                </span>
            <?php } elseif ($bh->budgetReel > $bh->budgetPrevisionnel * 0.25) { ?>
                <span class="has-text-warning">
                    <?= number_to_currency($bh->budgetReel, 'EUR', 'fr_FR', 2); ?>
                </span>
            <?php } else { ?>
                <span class="has-text-danger">
                    <?= number_to_currency($bh->budgetReel, 'EUR', 'fr_FR', 2); ?>
                </span>
            <?php } ?>
            <br>

            <strong>Budget Utilisé :</strong>
            <?php if ($bh->depenses > $bh->budgetReel * 0.5) { ?>
                <span class="has-text-danger">
                    <?= number_to_currency($bh->depenses, 'EUR', 'fr_FR', 2); ?>
                </span>
            <?php } elseif ($bh->depenses > $bh->budgetReel * 0.25) { ?>
                <span class="has-text-warning">
                    <?= number_to_currency($bh->depenses, 'EUR', 'fr_FR', 2); ?>
                </span>
            <?php } else { ?>
                <span class="has-text-success">
                    <?= number_to_currency($bh->depenses, 'EUR', 'fr_FR', 2); ?>
                </span>
            <?php } ?>
            <br>
            <strong>Ligne créée</strong>
            <time><?= Time::createFromTimestamp($bh->dateCreation)->humanize() ?></time>
            <div id="chart_div"></div>

        </div>
        <div class="column is-two-thirds is-narrow ">
            <p class="card-header-title">Historique : </p>
            <div class="box" style="height: 490px; overflow: auto">
                <?php foreach ($logs as $log) { ?>
                    Le <?= Time::createFromTimestamp($log->date, 'Europe/Paris', 'fr_FR') ?>, <?= getItemFromIri($log->userActor)->prenom . " " . getItemFromIri($log->userActor)->nom ?> à <?php
                    switch ($log->action) {
                        case 'create':
                            ?>créé un(e)
                            <?php break;
                        case 'update': ?>
                            mis à jour un(e)
                            <?php break;
                        case 'delete':
                            ?>
                            supprimé un(e)
                            <?php break;
                        case 'transfer':
                            ?>
                            transféré des crédits vers un(e)
                        <?php } ?>
                    <?= $log->target ?>
                    <br>
                    <?php if ($log->propertyChanged) { ?>
                        <?= $log->propertyChanged ?>:
                        <span class="has-text-danger"><strike><?= $log->oldValue ?></strike></span>
                        <span class="has-text-success"><?= $log->newValue ?></span>
                    <?php } ?>
                    <hr>
                <?php } ?>
            </div>
        </div>
    </div>
</div>


<div class="card column is-fullwidth is-vcentered m-5">
    <header class="card-header">
        <p class="card-header-title">
            Modifier la ligne </p>
        <a class="card-header-icon" href="#">
            <span class="icon">
        <i class="fas fa-angle-down" aria-hidden="true"></i>
      </span>
        </a>
    </header>
    <div class="card-content ">
        <div class="content columns is-centered">
            <div class=" column ">
                <button class="js-modal-edit-headers button is-info" data-target="js-modal-edit-headers">
                    Editer les en-têtes de la ligne
                </button>

            </div>
            <div class="column ">
                <button class="js-modal-do-virement button is-info" data-target="js-modal-do-virement">
                    Faire un virement de crédits
                </button>
            </div>
            <div class="column ">
                <button class="js-modal-ask-credit button is-info" data-target="js-modal-ask-credit">
                    Demander un virement de crédits
                </button>
            </div>
        </div>
    </div>
</div>
<div class="container is-fullwidth ">
    <div class="has-text-centered">
        <p class="subtitle is-3 ">Liste des bons de commandes rattachés a cette ligne</p>

    </div>
    <table id="example" class="display table is-striped is-hoverable is-narrow" style="width:100%">
        <thead>
        <tr>
            <th>#</th>
            <th>Numéro</th>
            <th>Imputation</th>
            <th>Label</th>
            <th>Montant</th>
            <th>Date de création</th>
            <th>Fournisseur</th>
            <th>Marché publique</th>
            <th>Emetteur</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($purchaseOrders as $po) { ?>
            <tr>
                <td><?= $po->id ?></td>
                <td><?= $po->number ?></td>
                <td><?= $po->imputation ?></td>
                <td><?= $po->label ?></td>
                <td><?= $po->montant ?></td>
                <td><?= $po->dateCreation ?></td>
                <td><?= getItemFromIri($po->fournisseur)->raisonSociale ?></td>
                <td><?= getItemFromIri($po->marche)->label ?></td>
                <td><?= getItemFromIri($po->emetteur)->prenom . " " . getItemFromIri($po->emetteur)->nom ?></td>
            </tr>
        <?php } ?>
        </tbody>
        <tfoot>
        <tr>
            <th>#</th>
            <th>Numéro</th>
            <th>Imputation</th>
            <th>Label</th>
            <th>Montant</th>
            <th>Date de création</th>
            <th>Fournisseur</th>
            <th>Marché publique</th>
            <th>Emetteur</th>
        </tr>
        </tfoot>
    </table>
</div>
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
        (document.querySelectorAll('.js-modal-edit-headers') || []).forEach(($trigger) => {
            const modal = $trigger.dataset.target;
            const $target = document.getElementById(modal);
            console.log($target);

            $trigger.addEventListener('click', () => {
                openModal($target);
            });
        });
        (document.querySelectorAll('.js-modal-do-virement') || []).forEach(($trigger) => {
            const modal = $trigger.dataset.target;
            const $target = document.getElementById(modal);
            console.log($target);

            $trigger.addEventListener('click', () => {
                openModal($target);
            });
        });
        (document.querySelectorAll('.js-modal-ask-credit') || []).forEach(($trigger) => {
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
