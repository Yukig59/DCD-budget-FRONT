<?= $this->extend('navbar') ?>
<?= $this->section('content') ?>


    {% if bh is not empty %}
        <div class="card column is-fullwidth is-vcentered m-5">
            <header class="card-header">
                <p class="card-header-title">
                    {{ bh.bhLabel }} | N° {{ bh.bhNumeroLigne }} (Type : {{ bh.bhTypeLabel.typeLabel }})
                </p>
                <a class="card-header-icon" href="#">
                    {#  TODO Link to stats #}
                        <span class="icon">
                        <i class="fas fa-pie-chart" aria-hidden="true"></i>
                    </span>
                </a>
            </header>
            <div class="card-content columns is-narrow">
                <div class="content column is-one-third">

                    <strong>Budget prévisionnel :</strong>
                    {{ bh.bhBudgetPrevisionnel |format_currency('EUR') }}
                    <br>
                    <strong>Budget Réel :</strong>
                    {% if bh.bhBudgetReel > bh.bhBudgetPrevisionnel *0.50 %}
                        <span class="has-text-success">{{ bh.bhBudgetReel | format_currency('EUR') }}</span>
                    {% elseif bh.bhBudgetReel > bh.bhBudgetPrevisionnel *0.25 %}
                        <span class="has-text-warning">{{ bh.bhBudgetReel | format_currency('EUR') }}</span>
                    {% else %}
                        <span class="has-text-danger">{{ bh.bhBudgetReel | format_currency('EUR') }}</span>
                    {% endif %}
                    <br>
                    <strong>Budget Disponible :</strong>
                    {% if bh.bhDisponible > bh.bhBudgetReel *0.50 %}
                        <span class="has-text-success">{{ bh.bhDisponible | format_currency('EUR') }}</span>
                    {% elseif bh.bhDisponible > bh.bhBudgetReel *0.25 %}
                        <span class="has-text-warning">{{ bh.bhDisponible | format_currency('EUR') }}</span>
                    {% else %}
                        <span class="has-text-danger">{{ bh.bhDisponible | format_currency('EUR') }}</span>
                    {% endif %}
                    <br>
                    <strong>Budget Utilisé :</strong>
                    {% if bh.bhDepenses > bh.bhBudgetReel *0.75 %}
                        <span class="has-text-danger">{{ bh.bhDepenses | format_currency('EUR') }}</span>
                    {% elseif bh.bhDepenses > bh.bhBudgetReel *0.5 %}
                        <span class="has-text-warning">{{ bh.bhDepenses | format_currency('EUR') }}</span>
                    {% else %}
                        <span class="has-text-success">{{ bh.bhDepenses | format_currency('EUR') }}</span>
                    {% endif %}
                    <br>
                    Ligne créée le :
                    <time>{{ bh.bhCreatedAt | date("d/m/Y h:i:s") }}</time>
                </div>
                <div class="column is-two-thirds is-narrow ">
                    <p class="card-header-title">Historique : </p>
                    <div class="box" style="height: 490px; overflow: auto">
                        {% for history in historique %}
                            Le {{ history.date.date | date("d/m/Y H:i") }}, {{ history.user }} à {{ history.action|lower }} un {{ history.target }}
                            <br>
                            {% if history.action != "CREATE" %}


                                {% if history.changedProperty|default %}
                                    {{ history.changedProperty }}:
                                    <span class="has-text-danger"><strike>{{ history.oldValue|default }}</strike></span>
                                    <span class="has-text-success"> {{ history.newValue|default }}</span>
                                {% endif %}
                            {% endif %}
                            <hr>
                        {% endfor %}

                    </div>
                </div>
            </div>
        </div>
        {#        TODO Ajouter un chart de la ligne #}


            <div class="card column is-fullwidth is-vcentered m-5">
            <header class="card-header">
                <p class="card-header-title">
        Modifier la ligne </p>
                <a class="card-header-icon" href="#">
                    {#  TODO dropdown #}
                        <span class="icon">
        <i class="fas fa-angle-down" aria-hidden="true"></i>
      </span>
                </a>
            </header>
            <div class="card-content ">
                <div class="content columns is-centered">
                    <div class=" column ">
                        <a class="button is-info" href="{{ path('edit_bh',  {'codeLigne': bh.bhNumeroLigne }) }}">
                        Editer les en-têtes de la ligne
                    </a>

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
    {% else %}
        {#
            {% if message is not empty %}
            <div class="container is-half">
                <div class="notification {{ message.class }}">
                    <button class='delete'></button>
                    {{ message.body }}
                    <p>Code :{{ message.code }}</p>
                </div>
            </div>
        {% endif %} #}
    {% endif %}


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

<?= $this->endsection('content') ?>
