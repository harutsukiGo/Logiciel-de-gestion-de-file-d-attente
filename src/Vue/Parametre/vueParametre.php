<section class="headerServiceAdministration">
<h2> Configuration Système </h2>
</section>
<?php use App\file\Modele\Repository\ParametresRepository;?>

<div class="divParametresAdministration">
    <div class="divChildParametresAdministration">
        <h2 class="titreDivParamatres"> Paramètres généraux </h2>
    <div>
        <p> Nom de l'entreprise </p>
        <label>
            <input type="text" placeholder="Nom de l'organisation" id="nomOrganisation" value="<?php
            $parametre=(new ParametresRepository())->getValeur("nom_organisation");
            echo $parametre->getValeur(); ?>">
        </label>
    </div>
    </div>

    <div class="divChildParametresAdministration">
        <h2 class="titreDivParamatres"> Horaires </h2>
        <div class="divInputTime">
            <label>
                <p> Ouverture </p>
                <input type="time" id="ouvertureParametres" value="<?php
                echo (new ParametresRepository())->getValeur("heure_ouverture")->getValeur(); ?>">
            </label>
            <label>
                <p> Fermeture </p>
                <input type="time" id="fermetureParametres" value="<?php
                echo (new ParametresRepository())->getValeur("heure_fermeture")->getValeur(); ?>">
            </label>
        </div>
    </div>


    <div class="divChildParametresAdministration">
        <h2 class="titreDivParamatres"> Paramètres audio </h2>
    <div class="sliderConteneur">
        <p>Volume des annonces </p>
        <label>
            <input type="range" min="0" max="1" step="0.1" value="1" id="sliderRange" class="inputSlider" oninput="ajusterVolume()">
        </label>
    </div>
        <div class="divSelectVoix">
            <p> Voix </p>
        </div>
    </div>

    <div class="divButtonParametres">
        <button id="btnEnregistrerParametres" class="btnEnregistrerParametres" onclick="mettreAJourParametres()">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-save w-5 h-5"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
            <span>Enregistrer les paramètres</span>
    </button>
    </div>


</div>