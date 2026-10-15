<?php
/**
 * Formulaire dInscription & Soumission de Projet
 * EcoSmart Lab - ECAM-EPMI 1AE
 */
$pageTitle = "Deposer un Projet dInnovation";
$extraScripts = ['js/form-validation.js', 'js/jspdf-export.js'];

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/header.php';
?>

<div class="container py-4">
    <!-- En-tete de la page -->
    <div class="text-center max-w-700 mx-auto mb-4">
        <span class="badge bg-primary-subtle text-primary fw-semibold mb-2">
            <i class="bi bi-file-earmark-code-fill me-1"></i> Etape 2 & 3 du Cahier des Charges
        </span>
        <h1 class="fw-bold">Formulaire de Soumission de Projet</h1>
        <p class="text-muted">
            Renseignez lensemble des informations ci-dessous pour enregistrer votre projet en base de donnees, generer votre recapitulatif interactif et telecharger votre fiche PDF officielle.
        </p>
    </div>

    <!-- Barre de Progression Dynamique (Interactivite JS) -->
    <div class="card-custom p-3 mb-4 shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <small class="fw-bold text-muted"><i class="bi bi-check2-circle text-primary me-1"></i> Progression de la saisie</small>
            <small class="text-muted">Completez les champs obligatoires (*)</small>
        </div>
        <div class="progress" style="height: 10px;">
            <div id="formProgressBar" class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: 15%;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">15%</div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Colonne Gauche : Formulaire Principal (PAS DANS UN TABLEAU) -->
        <div class="col-lg-8">
            <div class="form-container">
                <form id="projectForm" action="actions/create.php" method="POST" novalidate>
                    <!-- Jeton de securite CSRF -->
                    <input type="hidden" name="csrf_token" value="<?= generate_csrf_token() ?>">

                    <!-- ETAPE 1 : Identite de lEtudiant / Porteur -->
                    <div class="form-step-header">
                        <div class="step-number">1</div>
                        <div>
                            <h4 class="fw-bold mb-0">Identite & Informations Generales</h4>
                            <small class="text-muted">Coordonnees de contact du porteur principal</small>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="nom" class="form-label">Nom de famille *</label>
                            <input type="text" class="form-control" id="nom" name="nom" required placeholder="Ex: Dupont" value="<?= e($_POST['nom'] ?? '') ?>">
                            <div class="invalid-feedback">Veuillez indiquer un nom valide (min. 2 caracteres).</div>
                        </div>
                        <div class="col-md-6">
                            <label for="prenom" class="form-label">Prenom *</label>
                            <input type="text" class="form-control" id="prenom" name="prenom" required placeholder="Ex: Alexandre" value="<?= e($_POST['prenom'] ?? '') ?>">
                            <div class="invalid-feedback">Veuillez indiquer un prenom valide.</div>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Courriel Etudiant / Professionnel *</label>
                            <input type="email" class="form-control" id="email" name="email" required placeholder="a.dupont@epmi-edu.fr" value="<?= e($_POST['email'] ?? '') ?>">
                            <div class="invalid-feedback">Veuillez renseigner une adresse email valide.</div>
                        </div>
                        <div class="col-md-6">
                            <label for="telephone" class="form-label">Numero de Telephone *</label>
                            <input type="tel" class="form-control" id="telephone" name="telephone" required placeholder="+33 6 12 34 56 78" value="<?= e($_POST['telephone'] ?? '') ?>">
                            <div class="invalid-feedback">Veuillez renseigner un numero de telephone valide.</div>
                        </div>

                        <!-- Boutons Radio : Niveau detudes -->
                        <div class="col-12">
                            <label class="form-label d-block">Promotion / Niveau dEtudes *</label>
                            <div class="row g-2">
                                <div class="col-sm-4 col-6">
                                    <label class="custom-radio-card active">
                                        <input type="radio" name="niveau_etudes" value="1AE" checked>
                                        <span>1AE (1ere Annee)</span>
                                    </label>
                                </div>
                                <div class="col-sm-4 col-6">
                                    <label class="custom-radio-card">
                                        <input type="radio" name="niveau_etudes" value="2AE">
                                        <span>2AE (2eme Annee)</span>
                                    </label>
                                </div>
                                <div class="col-sm-4 col-6">
                                    <label class="custom-radio-card">
                                        <input type="radio" name="niveau_etudes" value="3AE">
                                        <span>3AE (3eme Annee)</span>
                                    </label>
                                </div>
                                <div class="col-sm-4 col-6">
                                    <label class="custom-radio-card">
                                        <input type="radio" name="niveau_etudes" value="4AE/5AE">
                                        <span>4AE / 5AE (Master)</span>
                                    </label>
                                </div>
                                <div class="col-sm-4 col-6">
                                    <label class="custom-radio-card">
                                        <input type="radio" name="niveau_etudes" value="Enseignant/Chercheur">
                                        <span>Chercheur / Enseignant</span>
                                    </label>
                                </div>
                                <div class="col-sm-4 col-6">
                                    <label class="custom-radio-card">
                                        <input type="radio" name="niveau_etudes" value="Partenaire Industriel">
                                        <span>Partenaire Indus.</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Liste Deroulante (Select) : Filiere -->
                        <div class="col-12">
                            <label for="filiere" class="form-label">Filiere dIngenierie de Rattachement *</label>
                            <select class="form-select" id="filiere" name="filiere" required>
                                <option value="" disabled selected>-- Choisissez une filiere dingenierie --</option>
                                <option value="Energie & Developpement Durable">Energie & Developpement Durable (Smart Grids, Solaire, Efficacite)</option>
                                <option value="Systemes dInformation & IA">Systemes dInformation & IA (Machine Learning, Cloud, Cybersecurite)</option>
                                <option value="Robotique & Systemes Embarques">Robotique & Systemes Embarques (Drones, IoT, STM32, Capteurs)</option>
                                <option value="Mobilite Electrique & Smart Cities">Mobilite Electrique & Smart Cities (V2G, Bornes, Gestion Urbaine)</option>
                                <option value="Genie Industriel & 4.0">Genie Industriel & 4.0 (Automatisation, Jumeaux Numeriques, Lean)</option>
                            </select>
                            <div class="invalid-feedback">Veuillez selectionner une filiere.</div>
                        </div>
                    </div>

                    <!-- ETAPE 2 : Descriptif Technique du Projet -->
                    <div class="form-step-header">
                        <div class="step-number">2</div>
                        <div>
                            <h4 class="fw-bold mb-0">Specifications du Projet & Innovation</h4>
                            <small class="text-muted">Nature du projet, objectifs et domaines technologiques</small>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-12">
                            <label for="titre_projet" class="form-label">Intitule / Titre du Projet *</label>
                            <input type="text" class="form-control" id="titre_projet" name="titre_projet" required placeholder="Ex: Systeme Intelligent dOptimisation des Panneaux Photovoltaiques" value="<?= e($_POST['titre_projet'] ?? '') ?>">
                            <div class="invalid-feedback">Veuillez indiquer un titre explicite (min. 5 caracteres).</div>
                        </div>

                        <!-- Boutons Radio : Type de projet -->
                        <div class="col-12">
                            <label class="form-label d-block">Typologie du Projet *</label>
                            <div class="row g-2">
                                <div class="col-md-6 col-12">
                                    <label class="custom-radio-card active">
                                        <input type="radio" name="type_projet" value="Projet Semestriel" checked>
                                        <span><i class="bi bi-mortarboard text-primary me-1"></i> Projet Semestriel 1AE</span>
                                    </label>
                                </div>
                                <div class="col-md-6 col-12">
                                    <label class="custom-radio-card">
                                        <input type="radio" name="type_projet" value="R&D">
                                        <span><i class="bi bi-lightbulb text-warning me-1"></i> Recherche & Developpement</span>
                                    </label>
                                </div>
                                <div class="col-md-6 col-12">
                                    <label class="custom-radio-card">
                                        <input type="radio" name="type_projet" value="Prototype Industriel">
                                        <span><i class="bi bi-gear-wide-connected text-danger me-1"></i> Prototype Industriel</span>
                                    </label>
                                </div>
                                <div class="col-md-6 col-12">
                                    <label class="custom-radio-card">
                                        <input type="radio" name="type_projet" value="Hackathon / Associatif">
                                        <span><i class="bi bi-trophy text-success me-1"></i> Hackathon / Innovation</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Cases a cocher (Checkboxes) : Domaines cles -->
                        <div class="col-12">
                            <label class="form-label d-block">Domaines Cles & Technologies Employees * (Selectionnez au moins un)</label>
                            <div class="row g-2">
                                <div class="col-sm-6">
                                    <label class="custom-check-card active">
                                        <input type="checkbox" name="domaines_cles[]" value="Energies Renouvelables" checked>
                                        <span><i class="bi bi-sun text-warning me-1"></i> Energies Renouvelables</span>
                                    </label>
                                </div>
                                <div class="col-sm-6">
                                    <label class="custom-check-card">
                                        <input type="checkbox" name="domaines_cles[]" value="Intelligence Artificielle">
                                        <span><i class="bi bi-cpu text-primary me-1"></i> Intelligence Artificielle</span>
                                    </label>
                                </div>
                                <div class="col-sm-6">
                                    <label class="custom-check-card">
                                        <input type="checkbox" name="domaines_cles[]" value="IoT & Capteurs Connectes">
                                        <span><i class="bi bi-wifi text-info me-1"></i> IoT & Capteurs Connectes</span>
                                    </label>
                                </div>
                                <div class="col-sm-6">
                                    <label class="custom-check-card">
                                        <input type="checkbox" name="domaines_cles[]" value="Robotique & Drones">
                                        <span><i class="bi bi-robot text-purple me-1"></i> Robotique & Drones</span>
                                    </label>
                                </div>
                                <div class="col-sm-6">
                                    <label class="custom-check-card">
                                        <input type="checkbox" name="domaines_cles[]" value="Cybersecurite & Reseaux">
                                        <span><i class="bi bi-shield-lock text-danger me-1"></i> Cybersecurite & Reseaux</span>
                                    </label>
                                </div>
                                <div class="col-sm-6">
                                    <label class="custom-check-card">
                                        <input type="checkbox" name="domaines_cles[]" value="Efficacite Energetique">
                                        <span><i class="bi bi-battery-charging text-success me-1"></i> Efficacite Energetique</span>
                                    </label>
                                </div>
                            </div>
                            <div id="domainesError" class="text-danger small mt-1 d-none">Veuillez cocher au moins un domaine technologique.</div>
                        </div>

                        <!-- Champs numeriques & dates -->
                        <div class="col-md-4">
                            <label for="budget_estime" class="form-label">Budget Estime (€) *</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="budget_estime" name="budget_estime" min="0" step="50" value="1500" required>
                                <span class="input-group-text">€</span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label for="date_debut" class="form-label">Date Previsionnelle de Debut *</label>
                            <input type="date" class="form-control" id="date_debut" name="date_debut" required value="<?= date('Y-m-d', strtotime('+7 days')) ?>">
                        </div>

                        <div class="col-md-4">
                            <label for="duree_semaines" class="form-label">Duree Estimee (Semaines) *</label>
                            <input type="number" class="form-control" id="duree_semaines" name="duree_semaines" min="1" max="52" value="8" required>
                        </div>

                        <!-- Radio : Besoin dacces labo -->
                        <div class="col-12">
                            <label class="form-label d-block">Besoin dAcces aux Laboratoires & Equipements Electroniques ? *</label>
                            <div class="d-flex gap-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="besoin_laboratoire" id="laboOui" value="Oui" checked>
                                    <label class="form-check-label" for="laboOui">
                                        <strong>Oui</strong> (Oscilloscopes, bancs de puissance, FabLab 3D)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="besoin_laboratoire" id="laboNon" value="Non">
                                    <label class="form-check-label" for="laboNon">
                                        <strong>Non</strong> (Projet 100% logiciel / simulation numerique)
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Textarea : Description detaillee -->
                        <div class="col-12">
                            <label for="description" class="form-label">Description Detaillee & Objectifs Techniques *</label>
                            <textarea class="form-control" id="description" name="description" rows="5" required placeholder="Detaillez le probleme adresse, le materiel utilise, les etapes cles et les livrables attendus..."><?= e($_POST['description'] ?? '') ?></textarea>
                            <div class="invalid-feedback">Veuillez rediger une description detaillee dau moins 20 caracteres.</div>
                        </div>

                        <!-- Checkbox : Conditions et Engagement -->
                        <div class="col-12 mt-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="conditions" name="conditions" required checked>
                                <label class="form-check-label small" for="conditions">
                                    Je certifie lexactitude des informations fournies et mengage a respecter le reglement de securite des laboratoires de lECAM-EPMI. *
                                </label>
                                <div class="invalid-feedback">Lacceptation du reglement est obligatoire.</div>
                            </div>
                        </div>
                    </div>

                    <!-- Boutons dAction Principaux -->
                    <div class="d-flex flex-column flex-sm-row gap-3 pt-3 border-top">
                        <button type="submit" class="btn btn-primary btn-lg flex-grow-1 shadow">
                            <i class="bi bi-cloud-arrow-up-fill"></i> Enregistrer en Base MySQL (Etape 4)
                        </button>
                        <button type="button" id="btnOpenSummaryModal" class="btn btn-outline-secondary btn-lg">
                            <i class="bi bi-card-checklist"></i> Previsualiser Recapitulatif
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Colonne Droite : Recapitulatif Direct & Generation PDF jsPDF -->
        <div class="col-lg-4">
            <div class="live-summary-card shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold m-0"><i class="bi bi-eye-fill text-primary me-2"></i> Recapitulatif Direct</h5>
                    <span class="badge bg-success-subtle text-success small">Temps Reel</span>
                </div>
                <p class="text-muted small mb-3">
                    Ce panneau reflete instantanement votre saisie grace au module JavaScript interactif.
                </p>

                <div class="summary-item">
                    <span class="summary-label">Etudiant :</span>
                    <span class="summary-value text-primary" id="sum_nom">Non renseigne</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Email :</span>
                    <span class="summary-value text-truncate" id="sum_email">Non renseigne</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Promotion :</span>
                    <span class="summary-value" id="sum_niveau">1AE</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Filiere :</span>
                    <span class="summary-value text-truncate" id="sum_filiere">Non selectionnee</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Projet :</span>
                    <span class="summary-value text-truncate" id="sum_titre">Projet sans titre</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Type :</span>
                    <span class="summary-value" id="sum_type">Projet Semestriel</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Budget :</span>
                    <span class="summary-value text-success fw-bold" id="sum_budget">1 500,00 €</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Planning :</span>
                    <span class="summary-value" id="sum_date">A definir</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Acces Labo :</span>
                    <span class="summary-value" id="sum_labo">Oui</span>
                </div>
                <div class="mt-3">
                    <span class="summary-label d-block mb-1">Domaines Selectionnes :</span>
                    <div id="sum_domaines">
                        <span class="badge bg-secondary-subtle text-secondary">Energies Renouvelables</span>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Module Optionnel jsPDF : Generation PDF Automatique -->
                <div class="text-center">
                    <h6 class="fw-bold mb-2"><i class="bi bi-file-earmark-pdf-fill text-danger me-1"></i> Module jsPDF Automatique</h6>
                    <p class="text-muted small mb-3">Generez et telechargez directement votre fiche recapitulative au format PDF standardise.</p>
                    <button type="button" id="btnGeneratePDF" class="btn btn-danger w-100 shadow-sm">
                        <i class="bi bi-filetype-pdf me-1"></i> Telecharger la Fiche PDF (jsPDF)
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Recapitulatif Popup (Interactivite JS Etape 2) -->
<div class="modal fade" id="summaryModal" tabindex="-1" aria-labelledby="summaryModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="summaryModalTitle">
                    <i class="bi bi-card-checklist text-primary me-2"></i> Recapitulatif des Donnees Saisies
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body p-4" id="summaryModalContent">
                <!-- Rempli dynamiquement par JS -->
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-outline-danger" onclick="generateProjectPDF()">
                    <i class="bi bi-file-earmark-pdf-fill"></i> Exporter ce PDF
                </button>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Modifier les donnees</button>
                    <button type="button" class="btn btn-primary" onclick="document.getElementById('projectForm').submit()">
                        <i class="bi bi-check2-circle"></i> Confirmer & Enregistrer
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
