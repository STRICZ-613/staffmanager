<?php
require_once '../includes/session_check.php';
require_once '../config/db.php';

// Seuls admin et rh peuvent modifier
if ($_SESSION['role'] == 'employe') {
    header('Location: liste.php');
    exit;
}

$erreur = '';
$succes = '';

// Récupérer l'ID de l'employé
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: liste.php');
    exit;
}

$id = $_GET['id'];

// Récupérer les infos de l'employé
$stmt = $pdo->prepare("SELECT * FROM employes WHERE id = ?");
$stmt->execute([$id]);
$employe = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$employe) {
    header('Location: liste.php');
    exit;
}

// Récupérer les départements
$departements = $pdo->query("SELECT * FROM departements ORDER BY nom ASC")->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les postes du département actuel
$postes = $pdo->prepare("SELECT * FROM postes WHERE departement_id = ?");
$postes->execute([$employe['departement_id']]);
$postes = $postes->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email = trim($_POST['email']);
    $telephone = trim($_POST['telephone']);
    $salaire = trim($_POST['salaire']);
    $date_embauche = $_POST['date_embauche'];
    $poste_id = $_POST['poste_id'];
    $departement_id = $_POST['departement_id'];

    // Vérifications
    if (empty($nom) || empty($prenom) || empty($email) || empty($telephone) || empty($salaire) || empty($date_embauche) || empty($poste_id) || empty($departement_id)) {
        $erreur = "Tous les champs sont obligatoires.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreur = "L'adresse email est invalide.";
    } else {
        // Vérifier si l'email existe déjà pour un autre employé
        $check = $pdo->prepare("SELECT id FROM employes WHERE email = ? AND id != ?");
        $check->execute([$email, $id]);
        if ($check->rowCount() > 0) {
            $erreur = "Cet email est déjà utilisé par un autre employé.";
        } else {
            // Mettre à jour l'employé
            $stmt = $pdo->prepare("UPDATE employes SET nom=?, prenom=?, email=?, telephone=?, salaire=?, date_embauche=?, poste_id=?, departement_id=? WHERE id=?");
            $stmt->execute([$nom, $prenom, $email, $telephone, $salaire, $date_embauche, $poste_id, $departement_id, $id]);
            $succes = "Employé modifié avec succès !";

            // Recharger les infos
            $stmt = $pdo->prepare("SELECT * FROM employes WHERE id = ?");
            $stmt->execute([$id]);
            $employe = $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }
}
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>

<div class="container mt-4">
    <h2>Modifier un Employé</h2>

    <?php if ($erreur): ?>
        <div class="alert alert-danger"><?= $erreur ?></div>
    <?php endif; ?>
    <?php if ($succes): ?>
        <div class="alert alert-success"><?= $succes ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Nom</label>
                <input type="text" name="nom" class="form-control" value="<?= htmlspecialchars($employe['nom']) ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Prénom</label>
                <input type="text" name="prenom" class="form-control" value="<?= htmlspecialchars($employe['prenom']) ?>" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($employe['email']) ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Téléphone</label>
                <input type="text" name="telephone" class="form-control" value="<?= htmlspecialchars($employe['telephone']) ?>" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Salaire</label>
                <input type="number" name="salaire" class="form-control" value="<?= htmlspecialchars($employe['salaire']) ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Date d'embauche</label>
                <input type="date" name="date_embauche" class="form-control" value="<?= htmlspecialchars($employe['date_embauche']) ?>" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Département</label>
                <select name="departement_id" id="departement_id" class="form-control" required>
                    <option value="">-- Choisir un département --</option>
                    <?php foreach ($departements as $dept): ?>
                        <option value="<?= $dept['id'] ?>" <?= $dept['id'] == $employe['departement_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($dept['nom']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label>Poste</label>
                <select name="poste_id" id="poste_id" class="form-control" required>
                    <?php foreach ($postes as $poste): ?>
                        <option value="<?= $poste['id'] ?>" <?= $poste['id'] == $employe['poste_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($poste['titre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-warning">Modifier l'employé</button>
        <a href="liste.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>

<?php include '../includes/footer.php'; ?>