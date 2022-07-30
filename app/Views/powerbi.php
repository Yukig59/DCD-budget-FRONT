<?php

use App\Models\BudgetHeaderModel;
use App\Models\FournisseurModel;
use App\Models\MarketModel;
use App\Models\UserModel;
use CodeIgniter\I18n\Time;

$fournisseurModel = new FournisseurModel();
$marcheModel = new MarketModel();
$userModel = new UserModel();
$bhModel = new BudgetHeaderModel();
?>
<!--TABLEAU SERVICES-->
<table id="Services">
    <thead>
    <tr>
        <th>#</th>
        <th>Code</th>
        <th>Label</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($services as $service) { ?>
        <tr>
            <td><?= $service->id ?></td>
            <td><?= $service->code ?></td>
            <td><?= $service->label ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>

<!--TABLEAU MARCHES-->
<table>
    <thead>
    <tr>
        <th>#</th>
        <th>Code</th>
        <th>Label</th>
        <th>Date début</th>
        <th>Date fin</th>
        <th>Service</th>
        <th>Type</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($marches as $marche) { ?>
        <tr>
            <td><?= $marche->id ?></td>
            <td><?= $marche->code ?></td>
            <td><?= $marche->label ?></td>
            <td><?= Time::createFromTimestamp($marche->dateDebut) ?></td>
            <td><?= Time::createFromTimestamp($marche->dateFin) ?></td>
            <td><?= $marche->service->code ?></td>
            <td><?= $marche->type->label ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<!--TABLEAU FOURNISSEURS-->
<table>
    <thead>
    <tr>
        <th>#</th>
        <th>Raison Sociale</th>
        <th>Addresse</th>
        <th>Code Postal</th>
        <th>Ville</th>
        <th>Telephone</th>
        <th>Siret</th>
        <th>Service</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($fournisseurs as $fournisseur) { ?>
        <tr>
            <td><?= $fournisseur->id ?></td>
            <td><?= $fournisseur->raisonSociale ?></td>
            <td><?= $fournisseur->addressLine1 . " " . ($fournisseur->addressLine2 ?? '') ?></td>
            <td><?= $fournisseur->zipCode ?></td>
            <td><?= $fournisseur->city ?></td>
            <td><?= $fournisseur->telephone ?></td>
            <td><?= $fournisseur->siret ?></td>
            <td><?= getItemFromIri($fournisseur->service)->code ?></td>

        </tr>
    <?php } ?>
    </tbody>
</table>
<!--TABLEAU UTILISATEURS-->
<table>
    <thead>
    <tr>
        <th>#</th>
        <th>Nom</th>
        <th>Prenom</th>
        <th>Email</th>
        <th>Service</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($users as $user) { ?>
        <tr>
            <td><?= $user->id ?></td>
            <td><?= $user->nom ?></td>
            <td><?= $user->prenom ?></td>
            <td><?= $user->email ?></td>
            <td><?= $user->service->code ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<!--TABLEAU Lignes de budget-->
<table>
    <thead>
    <tr>
        <th>#</th>
        <th>Label</th>
        <th>N°</th>
        <th>Budget Prévisionnel</th>
        <th>Budget dépensé</th>
        <th>Budget restant</th>
        <th>Date de création</th>
        <th>Service</th>
        <th>Type</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($budgetHeaders as $bh) { ?>
        <tr>
            <td><?= $bh->id ?></td>
            <td><?= $bh->label ?></td>
            <td><?= $bh->number ?></td>
            <td><?= $bh->budgetPrevisionnel ?></td>
            <td><?= $bh->depenses ?></td>
            <td><?= $bh->budgetReel ?></td>
            <td><?= Time::createFromTimestamp($bh->dateCreation) ?></td>
            <td><?= $bh->service->code ?></td>
            <td><?= $bh->type->label ?></td>

        </tr>
    <?php } ?>
    </tbody>
</table>
<!--TABLEAU PURCHASEORDERS-->
<table>
    <thead>
    <tr>
        <th>#</th>
        <th>N°</th>
        <th>Label</th>
        <th>Imputation</th>
        <th>Montant</th>
        <th>date Creation</th>
        <th>Fournisseur</th>
        <th>Marché</th>
        <th>Emetteur</th>
        <th>Ligne de budget</th>
        <th>Service</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($purchaseOrders as $po) { ?>
        <tr>
            <td><?= $po->id ?></td>
            <td><?= $po->number ?></td>
            <td><?= $po->label ?></td>
            <td><?= $po->imputation ?></td>
            <td><?= $po->montant ?></td>
            <td><?= Time::createFromTimestamp($po->dateCreation) ?></td>
            <td><?= $fournisseurModel->getFournisseursById($po->fournisseur->id)->raisonSociale ?></td>
            <td><?= $marcheModel->getMarketById($po->marche->id)->label ?></td>
            <td><?= $userModel->getUserById($po->emetteur->id)->email ?></td>
            <td><?= $bhModel->getBudgetHeaderById($po->budgetHeader->id)->label ?></td>
            <td><?= getItemFromIri("/api/services/" . $po->service->id)->code ?></td>

        </tr>
    <?php } ?>
    </tbody>
</table>
