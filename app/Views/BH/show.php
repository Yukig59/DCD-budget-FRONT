<?php

use CodeIgniter\I18n\Time;

?>
<?= $this->extend('navbar') ?>
<?= $this->section('content') ?>
<head>
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
                'titleTextStyle':{position: 'top',alignment: "center"}
            };

            // Instantiate and draw our chart, passing in some options.
            var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }
    </script>
</head>
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
<!--                    --><?php //var_dump($log);die(); ?>
                    Le <?= Time::createFromTimestamp($log->date, 'Europe/Paris', 'fr_FR') ?>, <?= getItemFromIri($log->userActor)->prenom . " " . getItemFromIri($log->userActor)->nom ?> à <?php
                    switch ($log->action) {
                        case 'create':
                            ?>créé
                            <?php break;
                        case 'update': ?>
                            mis à jour
                            <?php break;
                        case 'delete':
                            ?>
                            supprimé
                            <?php break;
                    } ?> un
                    <?= $log->target ?>
                    <br>
                    <?php if ($log->action !== "create") { ?>
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
                <div class="button is-info">
                    Faire un virement de crédits
                </div>
            </div>
            <div class="column ">
                <a class="button is-info">
                    Demander un virement de crédits
                </a>
            </div>
        </div>
    </div>
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
