<?= $this->extend('navbar') ?>
<?= $this->section('content') ?>
<div id="modal-js-edit">
    <div class="modal-background"></div>
    <div class="modal-content">
        <div class="box">
            <button class="modal-close is-large" aria-label="close"></button>
            <header class="modal-card-head">
                <p class="title is-3 has-text-centered has-text-dark"><strong>Modifier un bon de commande</strong>
                </p>
            </header>
            <div class="hero-body has-text-centered is-fullwidth" style="justify-content: center">
                <form method="post" action="<?= base_url("/purchase-order/edit/" . $po->id) ?>">
                    <div class="field ">
                        <label for="imputation" class="label">Imputation budgétaire</label>
                        <div class="control has-icons-left">
                            <input type="number" class="input is-rounded" value="<?= $po->imputation ?>"
                                   name="imputation"
                                   id="imputation">
                            <span class="icon is-small is-left">
                                    <i class="fas fa-edit"></i>
                                </span>
                        </div>
                    </div>
                    <div class="field">
                        <label for="label" class="label">Label</label>
                        <div class="control has-icons-left">
                            <input type="text" name="label" id="label" value="<?= $po->label ?>"
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
                                   value="<?= $po->montant ?>">
                            <span class="icon is-small is-left">
                                    <i class="fas fa-euro"></i>
                                </span>
                        </div>
                    </div>
                    <div class="field">
                        <label for="number" class="label">N° de bon de commande</label>
                        <div class="control has-icons-left">
                            <input type="text" class="input is-rounded" name="number" id="number"
                                   value="<?= $po->number ?>">
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
                                        <option value="<?= $marche->id ?>"
                                                <?php if ($po->marche->id == $marche->id){ ?>selected <?php } ?> ><?= $marche->label ?></option>
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
                                    <option value="Fonctionnement"
                                            <?php if ($po->type->label == "Fonctionnement"){ ?>selected<?php } ?> >
                                        Fonctionnement
                                    </option>
                                    <option value="Investissement"
                                            <?php if ($po->type->label == "Investissement"){ ?>selected<?php } ?>>
                                        Investissement
                                    </option>
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
                                        <option value="<?= $user->id ?>" <?php if ($po->emetteur->id == $user->id) { ?> selected <?php } ?>><?= $user->prenom . " " . strtoupper($user->nom) ?></option>
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
                                        <option value="<?= $fournisseur->id ?>"<?php if ($po->fournisseur->id == $fournisseur->id) { ?> selected <?php } ?>><?= $fournisseur->raisonSociale ?></option>
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
                                        <option value="<?= $bh->id ?>" <?php if ($po->budgetHeader->id == $bh->id) { ?> selected <?php } ?>>
                                            <?= $bh->label . " (n° " . $bh->number . ")" ?>
                                        </option>
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
                                        <option value="<?= $user->id ?>" <?php if ($po->emetteur->id == $user->id) { ?> selected <?php } ?>><?= $user->prenom . " " . strtoupper($user->nom) ?></option>
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
<?= $this->endSection('content') ?>

