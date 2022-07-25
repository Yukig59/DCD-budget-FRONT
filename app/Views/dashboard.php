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
                ['Utilisé', <?= $totalDepensesInvestissement ?>],
                ['Restant', <?= $totalInvestissement ?>],

            ]);
            var data2 = new google.visualization.DataTable();
            data2.addColumn('string', 'Utilisé');
            data2.addColumn('number', 'Restant');
            data2.addRows([
                ['Utilisé', <?= $totalDepensesFonctionnement ?>],
                ['Restant', <?= $totalFonctionnement ?>],

            ]);
            var options2 = {
                'title': 'Fonctionnement',
                'backgroundColor': '#DBDBDB',
                'width': 350,
                'height': 350,
                'colors': ['red', 'green'],
                'legend': {position: 'middle', alignment: 'center'},
                titleTextStyle: {
                    fontSize: 24,
                    position: 'center'
                }
            };
            // Set chart options
            var options = {
                'title': 'Investissement',
                'backgroundColor': '#DBDBDB',
                'width': 350,
                'height': 350,
                'colors': ['red', 'green'],
                'legend': {position: 'middle', alignment: 'center'},
                titleTextStyle: {
                    fontSize: 24,
                    position: 'center'
                }
            };

            // Instantiate and draw our chart, passing in some options.
            var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
            chart.draw(data, options);
            var chart2 = new
            google.visualization.PieChart(document.getElementById('chart2_div'));
            chart2.draw(data2, options2);
        }
    </script>
</head>
<div class="is-flex columns mt-3 is-just-content-space-between">
    <div class="column is-3 is-boxed">
        <aside class="menu" style="
      position: sticky;
      display: inline-block;
      vertical-align: top;
      max-height: 100vh;
      overflow-y: auto;
      top: 0;
      bottom: 0;
      padding: 30px;
">
            <ul class="menu-list">
                <li><a href="<?= base_url('/dashboard') ?>">Dashboard</a></li>
            </ul>
            <p class="menu-label">
                Administration
            </p>
            <ul class="menu-list">
                <li>
                    <a>Lignes de budget</a>
                    <ul>
                        <li><a href="<?= base_url('/budget-headers') ?>">Liste des lignes de budget</a></li>
                        <li><a class="addbh" data-target="addbh">Ajouter une nouvelle ligne</a></li>
                        <li><a>Statistiques</a></li>
                    </ul>
                </li>
                <li>
                    <a>Bons de commandes</a>
                    <ul>
                        <li><a href="<?= base_url('/purchase-orders') ?>">Liste des bons de commandes</a></li>
                        <li><a class="addpo" data-target="addpo">Ajouter un bon de commande</a></li>
                        <li><a>Statistiques</a></li>
                    </ul>
                </li>
            </ul>
            <p class="menu-label">
                Configuration
            </p>
            <ul class="menu-list">
                <li><a href="<?= base_url("/gestion-service/") ?>"> Réglages du service</a></li>
            </ul>
        </aside>
    </div>
    <div class="column is-5">
        <p class="title is-3">Résumé des dépenses du service</p>
        <div class="columns is-left">
            <div id="chart_div"></div>
            <br>
            <div id="chart2_div"></div>
        </div>
    </div>
    <div class="column is-3" style="overflow: auto">
        <p class="title is-3">Chiffres clés</p>
        <p class="title is-5">Budget restant en fonctionnement</p>
        <?php foreach ($BudgetHeadersF as $bh) { ?>
            <p><?= $bh->label ?> (<?= $bh->budgetReel ?>
                /<?= $bh->budgetPrevisionnel ?> €)</p>
            <progress class="progress is-primary"
                      value="<?= ($bh->budgetReel == $bh->budgetPrevisionnel) ? $bh->budgetPrevisionnel : $bh->budgetPrevisionnel - ($bh->budgetPrevisionnel - $bh->budgetReel) ?>"
                      max="<?= $bh->budgetPrevisionnel ?>"></progress>
        <?php } ?>
        <p class="title is-5">Budget restant en investissement</p>
        <?php foreach ($BudgetHeadersI as $bh) { ?>
            <p><?= $bh->label ?> (<?= $bh->budgetReel ?>
                /<?= $bh->budgetPrevisionnel ?></p>
            <progress class="progress is-primary"
                      value="<?= ($bh->budgetReel == $bh->budgetPrevisionnel) ? $bh->budgetPrevisionnel : $bh->budgetPrevisionnel - ($bh->budgetPrevisionnel - $bh->budgetReel) ?>"
                      max="<?= $bh->budgetPrevisionnel ?>"></progress>
        <?php } ?>
    </div>
</div>
</div>
<?php if ($notification !== null) { ?>
    <div class="container " style="width: 100vw" id="notification">
        <div class="container is-half has-text-centered">
            <div class="notification has-background-warning ">
                Le service <?= $notification->fromService ?? null ?> vous a fait une demande de virement de credits
                de <?= number_to_currency($notification->montant, 'EUR', 'fr_FR', 2) ?? null ?>. Accepter ?
                <button class="acceptVirement button is-small is-success" data-target="acceptVirement">Oui</button>
                <a href="<?= base_url('/delete-notif/' . $session->id) ?>">
                    <button class="button is-small is-danger remove">Non</button>
                </a>
            </div>

        </div>
    </div>
    <div id="acceptVirement" class="acceptVirement modal" xmlns="http://www.w3.org/1999/html">
        <div class="modal-background"></div>
        <div class="modal-content">
            <div class="box">
                <button class="modal-close is-large" aria-label="close"></button>
                <header class="modal-card-head">
                    <p class="title is-3 has-text-centered has-text-dark"><strong>Accepter une demande de virement de
                            crédits</strong>
                    </p>
                </header>
                <div class="hero-body has-text-centered is-fullwidth" style="justify-content: center">
                    <p class="subtitle is-5">Montant de la demande
                        : <?= number_to_currency($notification->montant, 'EUR', 'fr_FR', 2) ?></p>
                    <form method="post" action="<?= base_url("/budget-headers/accept-virement") ?>">
                        <div class="field">
                            <label for="fromBhId" class="label">Ligne de budget à prélever</label>
                            <div class="control has-icons-left">
                                <div class="select is-fullwidth is-rounded">
                                    <select name="fromBhId" id="fromBhId">
                                        <?php foreach ($budgetHeaders as $bh) { ?>
                                            <option value="<?= $bh->id ?>"><?= $bh->label . " (Disponible : " . number_to_currency($bh->budgetReel, 'EUR', 'fr_FR', 2) . ")" ?></option>
                                        <?php } ?>
                                    </select>
                                    <span class="icon is-small is-left">
                                        <i class="fas fa-money-bill-1-wave"></i>
                                    </span>
                                </div>
                            </div>
                            <input type="hidden" name="toService" value="<?= $notification->fromService ?>">
                            <input type="hidden" name="toBhId" value="<?= $notification->secret->askForBhId ?>">
                            <input type="hidden" name="montant" value="<?= $notification->montant ?>">
                            <input type="hidden" name="toUser" value="<?= $notification->fromUser ?>">
                        </div>
                        <div class="columns is-centered m-2">
                            <input type="submit" class="button is-primary is-rounded" value="Enregistrer"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<div id="addpo" class="modal">
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

<div id="addbh" class="addbh modal" xmlns="http://www.w3.org/1999/html">
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
        (document.querySelectorAll(".addbh") || []).forEach(($trigger) => {
            const modal = $trigger.dataset.target;
            const $target = document.getElementById(modal);
            console.log($target);

            $trigger.addEventListener('click', () => {
                openModal($target);
            });
        });
        (document.querySelectorAll(".addpo") || []).forEach(($trigger) => {
            const modal = $trigger.dataset.target;
            const $target = document.getElementById(modal);
            console.log($target);

            $trigger.addEventListener('click', () => {
                openModal($target);
            });
        });
        (document.querySelectorAll(".acceptVirement") || []).forEach(($trigger) => {
            const modal = $trigger.dataset.target;
            const $target = document.getElementById(modal);
            console.log($target);

            $trigger.addEventListener('click', () => {
                openModal($target);
            });
        });
        // Add a click event on various child elements to close the parent modal
        (document.querySelectorAll('.modal-background, .modal-close, .remove, .modal-card-head .delete, .modal-card-foot .button') || []).forEach(($close) => {
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
        (document.querySelectorAll('.notification .remove') || []).forEach(($delete) => {
            const $notification = $delete.parentNode;

            $delete.addEventListener('click', () => {
                $notification.parentNode.removeChild($notification);
            });
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
