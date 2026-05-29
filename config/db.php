<?php
// Lire la configuration depuis config.xml
$xml = simplexml_load_file(__DIR__ . '/config.xml');

$host     = (string) $xml->database->host;
$dbname   = (string) $xml->database->name;
$username = (string) $xml->database->username;
$password = (string) $xml->database->password;

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die(json_encode([
        'error' => 'Connexion à la base de données échouée : ' . $e->getMessage()
    ]));
}