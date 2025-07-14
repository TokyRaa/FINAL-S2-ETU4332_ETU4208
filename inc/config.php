<?php
session_start();

$host    = 'localhost';
$db      = 'finals2';
$user    = 'root';       // à adapter
$pass    = '';           // à adapter
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opts = [
  PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $opts);
} catch (PDOException $e) {
    die("Erreur BDD : " . $e->getMessage());
}
