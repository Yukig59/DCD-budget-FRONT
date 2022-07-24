<?php

use CodeIgniter\I18n\Time;

?><?= $this->extend('navbar') ?>
<?= $this->section('content') ?>
<div id="modal-edit-market" class="mt-5">
    <div class="modal-background"></div>
    <div class="modal-content" style="overflow-y: hidden">
        <div class="box mt-5">
            <button class="modal-close is-large" aria-label="close"></button>
            <header class="modal-card-head">
                <p class="title is-3 has-text-centered has-text-dark"><strong>Modifier un
                        marché
                        publique</strong>
                </p>
            </header>
            <div class="hero-body has-text-centered is-fullwidth"
                 style="justify-content: center">
                <form action="<?= base_url('/market/edit/' . $market->id) ?>" method="post">
                    <div class="field ">
                        <label for="label" class="label">Label</label>
                        <div class="control has-icons-left">
                            <input type="text" name="label" id="label"
                                   value="<?= $market->label ?>"
                                   class="input is-rounded">
                            <span class="icon is-small is-left">
                                        <i class="fas fa-edit"></i>
                                    </span>
                        </div>
                    </div>
                    <div class="field">
                        <label for="numero" class="label">Numéro de marché</label>
                        <div class="control has-icons-left">
                            <input type="text" name="numero" id="numero"
                                   class="input is-rounded"
                                   value="<?= $market->code ?>">
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
                                    <option value="Procédure adaptée"<?php if ($market->type->label == "Procédure adaptée") { ?> selected<?php } ?>>
                                        Procédure adaptée
                                    </option>
                                    <option value="Prestataire unique"<?php if ($market->type->label == "Prestataire unique") { ?> selected<?php } ?>>
                                        Prestataire unique
                                    </option>
                                    <option value="Hors procédure"<?php if ($market->type->label == "Hors procédure") { ?> selected<?php } ?>>
                                        Hors procédure
                                    </option>
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
                                <input type="date" name="startDate" id="startDate"
                                       class="input is-rounded"
                                       value="<?= Time::createFromTimestamp($market->dateDebut)->toDateString() ?>">
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <label for="endDate" class="label">Date de fin du marché</label>
                        <div class="control  has-icons-left">
                            <div class="control is-fullwidth">
                                <input type="date" name="endDate" id="endDate"
                                       class="input is-rounded"
                                       value="<?= Time::createFromTimestamp($market->dateFin)->toDateString() ?>">
                            </div>
                        </div>
                    </div>
                    <div class="columns is-centered m-2">
                        <input type="submit" class="button is-primary is-rounded"
                               value="Enregistrer"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection('content') ?>

