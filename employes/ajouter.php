<?php
require_once '../includes/session_check.php';
require_once '../config/db.php';

// Seuls admin et rh peuvent ajouter
if ($_SESSION['role'] == 'employe') {
    header('Location: liste.php');
    exit;
}

$erreur = '';
$succes = '';

// Récupérer les départements
$departements = $pdo->query("SELECT * FROM departements ORDER BY nom ASC")->fetchAll(PDO::FETCH_ASSOC);

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
        // Vérifier si l'email existe déjà
        $check = $pdo->prepare("SELECT id FROM employes WHERE email = ?");
        $check->execute([$email]);
        if ($check->rowCount() > 0) {
            $erreur = "Cet email est déjà utilisé.";
        } else {
            // Insérer l'employé
            $stmt = $pdo->prepare("INSERT INTO employes (nom, prenom, email, telephone, salaire, date_embauche, poste_id, departement_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$nom, $prenom, $email, $telephone, $salaire, $date_embauche, $poste_id, $departement_id]);
            $succes = "Employé ajouté avec succès !";
        }
    }
}
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>

<div class="container mt-4">
    <h2>Ajouter un Employé</h2>

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
                <input type="text" name="nom" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Prénom</label>
                <input type="text" name="prenom" class="form-control" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Téléphone</label>
                <input type="text" name="telephone" class="form-control" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Salaire</label>
                <input type="number" name="salaire" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Date d'embauche</label>
                <input type="date" name="date_embauche" class="form-control" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Département</label>
                <select name="departement_id" id="departement_id" class="form-control" required>
                    <option value="">-- Choisir un département --</option>
                    <?php foreach ($departements as $dept): ?>
                        <option value="<?= $dept['id'] ?>"><?= htmlspecialchars($dept['nom']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label>Poste</label>
                <select name="poste_id" id="poste_id" class="form-control" required>
                    <option value="">-- Choisir d'abord un département --</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Ajouter l'employé</button>
        <a href="liste.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>

<?php include '../includes/footer.php'; ?>