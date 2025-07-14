<?php
session_start();

$host    = 'localhost';
$db      = 'db_s2_ETU004332';
$user    = 'ETU004332';    // à adapter
$pass    = 'fc0afSUc';        // à adapter
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
  PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("Erreur BDD : " . $e->getMessage());
}
