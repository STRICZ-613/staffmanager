<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/staffmanager/includes/session_check.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/staffmanager/config/db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/staffmanager/includes/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/staffmanager/includes/navbar.php';
?>

<main class="main-content">
    <div class="page-header">
        <h2>Tableau de Bord</h2>
        <p>Bienvenue, <?= htmlspecialchars($_SESSION['user_nom']) ?></p>
    </div>

    <div class="stats-grid">
        <!-- Les chiffres seront chargés dynamiquement via AJAX par Membre 3 -->
        <div class="stat-card" id="stat-employes">
            <div class="stat-icon">👥</div>
            <div class="stat-info">
                <span class="stat-number" id="nb-employes">...</span>
                <span class="stat-label">Employés</span>
            </div>
        </div>

        <div class="stat-card" id="stat-departements">
            <div class="stat-icon">🏢</div>
            <div class="stat-info">
                <span class="stat-number" id="nb-departements">...</span>
                <span class="stat-label">Départements</span>
            </div>
        </div>

        <div class="stat-card" id="stat-conges">
            <div class="stat-icon">📅</div>
            <div class="stat-info">
                <span class="stat-number" id="nb-conges">...</span>
                <span class="stat-label">Congés en attente</span>
            </div>
        </div>
    </div>

    <?php if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'rh'): ?>
    <div class="dashboard-actions">
        <h3>Actions rapides</h3>
        <div class="actions-grid">
            <a href="/staffmanager/employes/ajouter.php" class="action-card">
                ➕ Ajouter un employé
            </a>
            <a href="/staffmanager/conges/liste.php" class="action-card">
                📋 Voir les demandes de congés
            </a>
            <a href="/staffmanager/rapports/export_xml.php" class="action-card">
                📁 Exporter en XML
            </a>
        </div>
    </div>
    <?php endif; ?>
</main>

<!-- Script AJAX pour charger les stats (sera complété par Membre 3) -->
<script src="/staffmanager/assets/js/ajax.js"></script>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/staffmanager/includes/footer.php'; ?>