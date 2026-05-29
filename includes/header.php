<?php
$xml = simplexml_load_file($_SERVER['DOCUMENT_ROOT'] . '/staffmanager/config/config.xml');
$app_nom = (string) $xml->app->nom;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($app_nom) ?></title>
    <link rel="stylesheet" href="/staffmanager/assets/css/style.css">
</head>
<body>