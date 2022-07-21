<?php
$session = session();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>DCD - Budget Manager v5</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('css/styles.css') ?>">
</head>
<body>
<nav class="navbar" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="<?= base_url('/dashboard') ?>>">
            <img src="<?= base_url('/images/logo.png') ?>" alt="Le Havre Métropole Logo">
        </a>
        <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>
    <div id="navbarBasicExample" class="navbar-menu">
        <div class="navbar-start">
            <a class="navbar-item" href="<?= base_url('/dashboard') ?>">
                Dashboard
            </a>
            <a class="navbar-item">
                Documentation
            </a>
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">
                    Outils d'administration
                </a>
                <div class="navbar-dropdown">
                    <a class="navbar-item" href="<?= base_url('/budget-headers') ?>">
                        Gérer les lignes de budget
                    </a>
                    <a class="navbar-item" href="<?= base_url("/purchase-orders") ?>">
                        Gérer les bons de commandes
                    </a>
                    <a class="navbar-item" href="<?= base_url('/gestion-service') ?>">
                        Réglages du service
                    </a>
                </div>
            </div>
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">
                    Outils statistiques
                </a>
                <div class="navbar-dropdown">
                    <a class="navbar-item">
                        Lignes de budget
                    </a>
                    <a class="navbar-item">
                        Bons de commandes
                    </a>
                    <a class="navbar-item">
                        Service
                    </a>
                </div>
            </div>
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">
                    Générer des rapports
                </a>
                <div class="navbar-dropdown">
                    <a class="navbar-item">
                        Lignes de budget
                    </a>
                    <a class="navbar-item">
                        Bons de commandes
                    </a>
                    <a class="navbar-item">
                        Service
                    </a>
                </div>
            </div>
            <a class="navbar-item">
                <i class="fa fa-bug"></i>&nbsp;Signaler un bug
            </a>
        </div>
        <div class="navbar-end">

            <p class="navbar-item">Bonjour
            </p>
            <a class="navbar-item">
                <i class="fa fa-user"></i>&nbsp; <?= $session->prenom . " " . $session->nom ?>
            </a>
            <div class="navbar-item">
                <div class="buttons">
                    <a class="button is-primary" href="<?= base_url("/logout") ?>">
                        <strong>
                            Se déconnecter</strong>
                    </a>

                </div>
            </div>
        </div>
    </div>
</nav>
<?= $this->renderSection('content') ?>
</body>
</html>
