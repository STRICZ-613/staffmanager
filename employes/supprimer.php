<?php
require_once '../includes/session_check.php';
require_once '../config/db.php';

// Seuls admin et rh peuvent supprimer
if ($_SESSION['role'] == 'employe') {
    header('Location: liste.php');
    exit;
}

// Vérifier l'ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: liste.php');
    exit;
}

$id = $_GET['id'];

// Vérifier que l'employé existe
$stmt = $pdo->prepare("SELECT * FROM employes WHERE id = ?");
$stmt->execute([$id]);
$employe = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$employe) {
    header('Location: liste.php');
    exit;
}

// Supprimer l'employé
$stmt = $pdo->prepare("DELETE FROM employes WHERE id = ?");
$stmt->execute([$id]);

// Rediriger vers la liste
header('Location: liste.php?succes=Employé supprimé avec succès');
exit;
?>