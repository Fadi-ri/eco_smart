    </main>

    <!-- Pied de Page (Footer ) -->
    <footer class="footer-custom">
        <div class="container">
            <div class="row g-4 mb-4">
                <!-- Présentation École & Projet -->
                <div class="col-lg-4 col-md-6">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="brand-icon">
                            <i class="bi bi-cpu-fill"></i>
                        </div>
                        <h5 class="m-0 fw-bold"><?= APP_NAME ?></h5>
                    </div>
                    <p class="text-muted small mb-3">
                        Plateforme collaborative dédiée à l'innovation, à la transition énergétique et aux projets techniques d'ingénierie pour les étudiants de l'<strong>ECAM-EPMI (RAN - 1AE)</strong>.
                    </p>
                    <div class="d-flex gap-2 footer-social-links">
                        <a href="https://epmi.ymag.cloud" target="_blank" class="btn btn-outline-secondary btn-sm rounded-circle p-2" title="Yparéo ECAM-EPMI" style="width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center;">
                            <i class="bi bi-mortarboard-fill"></i>
                        </a>
                        <a href="https://github.com" target="_blank" class="btn btn-outline-secondary btn-sm rounded-circle p-2" title="GitHub" style="width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center;">
                            <i class="bi bi-github"></i>
                        </a>
                        <a href="https://linkedin.com" target="_blank" class="btn btn-outline-secondary btn-sm rounded-circle p-2" title="LinkedIn" style="width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center;">
                            <i class="bi bi-linkedin"></i>
                        </a>
                    </div>
                </div>

                <!-- Liens Rapides -->
                <div class="col-lg-2 col-md-6">
                    <h6 class="footer-title">Navigation</h6>
                    <ul class="footer-links">
                        <li><a href="index.php"><i class="bi bi-chevron-right small me-1"></i> Accueil</a></li>
                        <li><a href="projets.php"><i class="bi bi-chevron-right small me-1"></i> Innovations</a></li>
                        <li><a href="inscription.php"><i class="bi bi-chevron-right small me-1"></i> Déposer Projet</a></li>
                        <li><a href="admin.php"><i class="bi bi-chevron-right small me-1"></i> Dashboard CRUD</a></li>
                        <li><a href="a_propos.php"><i class="bi bi-chevron-right small me-1"></i> À Propos</a></li>
                    </ul>
                </div>

                <!-- Thématiques Ingénieur -->
                <div class="col-lg-3 col-md-6">
                    <h6 class="footer-title">Pôles d'Ingénierie</h6>
                    <ul class="footer-links">
                        <li><a href="projets.php?filiere=energie"><i class="bi bi-lightning-charge text-success me-1"></i> Énergies Renouvelables</a></li>
                        <li><a href="projets.php?filiere=ia"><i class="bi bi-cpu text-primary me-1"></i> Systèmes d'Information & IA</a></li>
                        <li><a href="projets.php?filiere=robotique"><i class="bi bi-robot text-warning me-1"></i> Robotique & IoT</a></li>
                        <li><a href="projets.php?filiere=mobilite"><i class="bi bi-ev-front text-purple me-1"></i> Smart Cities & Mobilité</a></li>
                        <li><a href="projets.php?filiere=industrie"><i class="bi bi-gear-wide text-danger me-1"></i> Industrie 4.0 & Jumeaux</a></li>
                    </ul>
                </div>

                <!-- Contact & Informations École -->
                <div class="col-lg-3 col-md-6">
                    <h6 class="footer-title">Campus & Contact</h6>
                    <p class="text-muted small mb-2">
                        <i class="bi bi-geo-alt-fill text-danger me-1"></i> 13 Boulevard de l'Hautil, 95092 Cergy-Pontoise Cedex
                    </p>
                    <p class="text-muted small mb-2">
                        <i class="bi bi-envelope-fill text-primary me-1"></i> contact-ran@epmi-edu.fr
                    </p>
                    <p class="text-muted small mb-3">
                        <i class="bi bi-telephone-fill text-success me-1"></i> +33 (0)1 30 75 60 40
                    </p>
                    <div class="badge bg-primary-subtle text-primary border border-primary-subtle p-2">
                        <i class="bi bi-calendar3 me-1"></i> Rendu Projet : 31 Octobre 2026
                    </div>
                </div>
            </div>

            <hr class="border-secondary-subtle my-4">

            <!-- Bas de page & Technologies -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                <p class="text-muted small m-0">
                    &copy; <?= APP_YEAR ?> <strong><?= APP_NAME ?></strong> — Projet Développement Web RAN 1AE. Tous droits réservés.
                </p>
                <div class="d-flex flex-wrap gap-2">
                    <span class="badge bg-dark-subtle text-body border small">HTML5</span>
                    <span class="badge bg-dark-subtle text-body border small">CSS3</span>
                    <span class="badge bg-dark-subtle text-body border small">JavaScript ES6</span>
                    <span class="badge bg-dark-subtle text-body border small">PHP 8 / PDO</span>
                    <span class="badge bg-dark-subtle text-body border small">MySQL</span>
                    <span class="badge bg-dark-subtle text-body border small">Bootstrap 5.3</span>
                    <span class="badge bg-dark-subtle text-body border small">jsPDF</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts JavaScript Tiers (Bootstrap 5.3 Bundle, jsPDF, Chart.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

    <!-- Scripts de l'application -->
    <script src="js/main.js"></script>
    <?php if (isset($extraScripts)): ?>
        <?php foreach ($extraScripts as $script): ?>
            <script src="<?= e($script) ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
