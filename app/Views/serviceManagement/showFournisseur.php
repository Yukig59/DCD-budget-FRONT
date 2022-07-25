<?php

use CodeIgniter\I18n\Time;

?><?= $this->extend('navbar') ?>
<?= $this->section('content') ?>
<div id="modal-js-add-fourn">
    <div class="modal-background" style="overflow-y: hidden"></div>
    <div class="modal-content" style="overflow-y: hidden">
        <div class="box">
            <header class="modal-card-head">
                <p class="title is-3 has-text-centered has-text-dark"><strong>Ajouter un fournisseur</strong>
                </p>
            </header>
            <div class="hero-body has-text-centered is-fullwidth" style="justify-content: center">
                <form action="<?= base_url("/fournisseur/edit/" . $fournisseur->id) ?>" method="post">
                    <div class="hero-body has-text-centered is-fullwidth" style="justify-content: center">
                        <div class="field ">
                            <label for="raisonSociale" class="label">Raison Sociale</label>
                            <div class="control has-icons-left">
                                <input type="text" name="raisonSociale" id="raisonSociale"
                                       class="input is-rounded is-fullwidth"
                                       value="<?= $fournisseur->raisonSociale ?>">
                                <span class="icon is-small is-left">
                                        <i class="fas fa-edit"></i>
                                    </span>
                            </div>
                        </div>
                        <div class="field">
                            <label for="siret" class="label">Siret</label>
                            <div class="control has-icons-left">
                                <input type="text" name="siret" id="siret" class="is-rounded input is-fullwidth"
                                       value="<?= $fournisseur->siret ?>">
                                <span class="icon is-small is-left">
                                        <i class="fas fa-info"></i>
                                    </span>
                            </div>
                        </div>
                        <div class="field">
                            <label for="addr1" class="label">Adresse ligne 1</label>
                            <div class="control has-icons-left">
                                <input type="text" name="addr1" id="addr1" class="input is-rounded is-fullwidth"
                                       value="<?= $fournisseur->addressLine1 ?>">
                                <span class="icon is-small is-left">
                                <i class="fas fa-warehouse"></i>
                            </span>
                            </div>
                        </div>
                        <div class="field">
                            <label for="addr2" class="label">Adresse ligne 1</label>
                            <div class="control has-icons-left">
                                <input type="text" name="addr2" id="addr2" class="input is-rounded is-fullwidth"
                                       value="<?= $fournisseur->addressLine2 ?? '' ?>">
                                <span class="icon is-small is-left">
                                <i class="fas fa-warehouse"></i>
                            </span>
                            </div>
                        </div>
                        <div class="field">
                            <label for="zipcode" class="label">Code Postal</label>
                            <div class="control  has-icons-left">
                                <input type="number" name="zipcode" id="zipcode"
                                       class="input is-rounded is-fullwidth" value="<?= $fournisseur->zipCode ?>">
                                <span class="icon is-small is-left">
                                <i class="fas fa-map-marked-alt"></i>
                            </span>
                            </div>
                        </div>
                        <div class="field">
                            <label for="city" class="label">Ville</label>
                            <div class="control has-icons-left">
                                <input type="text" name="city" id="city" value="<?= $fournisseur->city ?>"
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
                                       value="<?= $fournisseur->telephone ?>">
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
<?= $this->endSection('content') ?>

