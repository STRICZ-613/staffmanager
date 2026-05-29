<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<nav class="navbar">
    <div class="navbar-brand">
        <a href="/staffmanager/index.php">StaffManager</a>
    </div>

    <ul class="navbar-menu">
        <li>
            <a href="/staffmanager/index.php" 
               class="<?= $current_page === 'index.php' ? 'active' : '' ?>">
                Dashboard
            </a>
        </li>
        <li>
            <a href="/staffmanager/employes/liste.php"
               class="<?= $current_page === 'liste.php' ? 'active' : '' ?>">
                Employés
            </a>
        </li>

        <?php if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'rh'): ?>
        <li>
            <a href="/staffmanager/departements/liste.php">Départements</a>
        </li>
        <li>
            <a href="/staffmanager/postes/liste.php">Postes</a>
        </li>
        <li>
            <a href="/staffmanager/conges/liste.php">Congés</a>
        </li>
        <?php endif; ?>

        <?php if ($_SESSION['role'] === 'employe'): ?>
        <li>
            <a href="/staffmanager/conges/demande.php">Mes Congés</a>
        </li>
        <?php endif; ?>

        <?php if ($_SESSION['role'] === 'admin'): ?>
        <li>
            <a href="/staffmanager/rapports/export_xml.php">Export XML</a>
        </li>
        <?php endif; ?>
    </ul>

    <div class="navbar-user">
        <span>👤 <?= htmlspecialchars($_SESSION['user_nom']) ?></span>
        <span class="badge-role"><?= htmlspecialchars($_SESSION['role']) ?></span>
        <a href="/staffmanager/auth/logout.php" class="btn-logout">Déconnexion</a>
    </div>
</nav>