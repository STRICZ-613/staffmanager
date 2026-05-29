<?php
require_once '../includes/session_check.php';
require_once '../config/db.php';

// Récupérer tous les employés avec leur département et poste
$sql = "SELECT e.*, d.nom AS departement, p.titre AS poste 
        FROM employes e
        LEFT JOIN departements d ON e.departement_id = d.id
        LEFT JOIN postes p ON e.poste_id = p.id
        ORDER BY e.nom ASC";
$stmt = $pdo->query($sql);
$employes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les départements pour le filtre
$depts = $pdo->query("SELECT * FROM departements ORDER BY nom ASC")->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>

<div class="container mt-4">
    <h2>Liste des Employés</h2>

    <!-- Barre de recherche et filtre -->
    <div class="row mb-3">
        <div class="col-md-6">
            <input type="text" id="recherche" class="form-control" placeholder="Rechercher par nom ou prénom...">
        </div>
        <div class="col-md-4">
            <select id="filtre_dept" class="form-control">
                <option value="">-- Tous les départements --</option>
                <?php foreach ($depts as $dept): ?>
                    <option value="<?= $dept['id'] ?>"><?= htmlspecialchars($dept['nom']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'rh'): ?>
        <div class="col-md-2">
            <a href="ajouter.php" class="btn btn-primary w-100">+ Ajouter</a>
        </div>
        <?php endif; ?>
    </div>

    <!-- Tableau des employés -->
    <div id="tableau_employes">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Département</th>
                    <th>Poste</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="corps_tableau">
                <?php if (count($employes) > 0): ?>
                    <?php foreach ($employes as $emp): ?>
                    <tr>
                        <td><?= htmlspecialchars($emp['nom']) ?></td>
                        <td><?= htmlspecialchars($emp['prenom']) ?></td>
                        <td><?= htmlspecialchars($emp['email']) ?></td>
                        <td><?= htmlspecialchars($emp['telephone']) ?></td>
                        <td><?= htmlspecialchars($emp['departement']) ?></td>
                        <td><?= htmlspecialchars($emp['poste']) ?></td>
                        <td>
                            <a href="fiche.php?id=<?= $emp['id'] ?>" class="btn btn-info btn-sm">Voir</a>
                            <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'rh'): ?>
                                <a href="modifier.php?id=<?= $emp['id'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                                <a href="supprimer.php?id=<?= $emp['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cet employé ?')">Supprimer</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="7" class="text-center">Aucun employé trouvé</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../includes/footer.php'; ?>