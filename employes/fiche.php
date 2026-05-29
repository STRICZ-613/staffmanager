<?php
require_once '../includes/session_check.php';
require_once '../config/db.php';

// Vérifier l'ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: liste.php');
    exit;
}

$id = $_GET['id'];

// Récupérer les infos complètes de l'employé
$stmt = $pdo->prepare("SELECT e.*, d.nom AS departement, p.titre AS poste 
                        FROM employes e
                        LEFT JOIN departements d ON e.departement_id = d.id
                        LEFT JOIN postes p ON e.poste_id = p.id
                        WHERE e.id = ?");
$stmt->execute([$id]);
$employe = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$employe) {
    header('Location: liste.php');
    exit;
}
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>

<div class="container mt-4">
    <h2>Fiche Employé</h2>

    <div class="card mt-3">
        <div class="card-header bg-dark text-white">
            <h4><?= htmlspecialchars($employe['nom']) ?> <?= htmlspecialchars($employe['prenom']) ?></h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Email :</strong> <?= htmlspecialchars($employe['email']) ?></p>
                    <p><strong>Téléphone :</strong> <?= htmlspecialchars($employe['telephone']) ?></p>
                    <p><strong>Salaire :</strong> <?= htmlspecialchars($employe['salaire']) ?> FCFA</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Département :</strong> <?= htmlspecialchars($employe['departement']) ?></p>
                    <p><strong>Poste :</strong> <?= htmlspecialchars($employe['poste']) ?></p>
                    <p><strong>Date d'embauche :</strong> <?= htmlspecialchars($employe['date_embauche']) ?></p>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="liste.php" class="btn btn-secondary">Retour à la liste</a>
            <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'rh'): ?>
                <a href="modifier.php?id=<?= $employe['id'] ?>" class="btn btn-warning">Modifier</a>
                <a href="supprimer.php?id=<?= $employe['id'] ?>" class="btn btn-danger" onclick="return confirm('Supprimer cet employé ?')">Supprimer</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>