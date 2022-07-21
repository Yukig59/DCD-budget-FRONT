<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="<?= base_url('css/styles.css') ?>">
</head>
<body>
<section class="hero background-lh is-fullheight">
    <div class="hero-head mt-6">
        <div class="container has-text-centered ">
            <p class="title is-1 has-text-light">Budget Manager v5</p>
            <p class="subtitle is-3 has-text-light">Une application Le Havre Seine Métropole</p>
        </div>
    </div>

    <div class="hero-body has-text-centered" style="justify-content: center">
        <div class="login box has-background-white-bis has-shadow ">
            <div class="columns is-vcentered">
                <div class="column">

                    <img src="<?= base_url('images/logo.png') ?>" class="is-inline" width="150px" class="m-3"/>
                </div>
                <div class="column">
                    <p class="title is-inline is-3 has-text-centered has-text-dark is-align-self-center"><strong>Inscription
                            utilisateur</strong></p>
                </div>
            </div>
            <?php if (isset($message)) { ?>
                <div class="container is-half">
                    <div class="notification has-background-warning">
                        <button class='delete'></button>
                        <?= $message ?>
                    </div>
                </div>
            <?php } ?>
            <form role="form" action="<?= base_url("/register") ?>" method="post">
                <div class="columns">
                    <div class="column">
                        <div class="field">
                            <label for="userEmail" class="label is-medium">Email</label>
                            <div class="control has-icons-left">
                                <input type="email" name="userEmail" id="userEmail" class="input is-medium is-rounded"
                                       placeholder="budget.manager@lehavremetro.fr"/>
                                <span class="icon is-small is-left">
                                <i class="fas fa-at"></i>
                            </span>
                            </div>
                        </div>
                        <div class="field">
                            <label for="userNom" class="label is-medium">Nom</label>
                            <div class="control has-icons-left">
                                <input type="text" name="userNom" id="userNom" class="input is-medium is-rounded"
                                       placeholder="Dupont"/>
                                <span class="icon is-small is-left">
                                <i class="fas fa-user"></i>
                            </span>
                            </div>
                        </div>
                        <div class="field">
                            <label for="userPrenom" class="label is-medium">Prenom</label>
                            <div class="control has-icons-left">
                                <input type="text" name="userPrenom" id="userPrenom" class="input is-medium is-rounded"
                                       placeholder="Pierre"/>
                                <span class="icon is-small is-left">
                                <i class="fas fa-user"></i>
                            </span>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="field">
                            <label for="userService" class="label is-medium">Service</label>
                            <div class="select is-rounded is-medium">
                                <select name="userService" id="userService" class="select">
                                    <?php foreach ($services as $service) { ?>
                                        <option value="<?= $service->id ?>"><?= $service->code . " (" . $service->label . ")" ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="field">
                            <label for="userPassword" class="label is-medium">Mot de passe</label>
                            <div class="control has-icons-left">
                                <input type="password" name="userPassword" id="userPassword"
                                       class="input is-medium is-rounded"
                                       placeholder="**********"/>
                                <span class="icon is-small is-left">
                                <i class="fas fa-key"></i>
                            </span>
                            </div>
                        </div>
                        <div class="field">
                            <label for="userPasswordSecond" class="label is-medium">Répétez votre mot de passe</label>
                            <div class="control has-icons-left">
                                <input type="password" name="userPasswordSecond" id="userPasswordSecond"
                                       class="input is-medium is-rounded"
                                       placeholder="**********"/>
                                <span class="icon is-small is-left">
                                <i class="fas fa-key"></i>
                            </span>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="columns is-centered m-2">
                    <input type="submit" name="submit" value="Connexion"
                           class="button is-block is-halfwidth is-success is-medium is-rounded">
                </div>
            </form>
        </div>
    </div>
</section>
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
</body>
</html>
