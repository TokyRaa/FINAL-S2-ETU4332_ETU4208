<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Emprunt d’Objets</title>
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="liste_objets.php">EmpruntObjets</a>
    <div>
      <?php if(!empty($_SESSION['membre'])): ?>
        <span class="me-3">Salut, <?=htmlspecialchars($_SESSION['membre']['nom'])?></span>
        <a href="logout.php" class="btn btn-sm btn-outline-danger">Déconnexion</a>
      <?php else: ?>
        <a href="login.php" class="btn btn-sm btn-outline-primary me-2">Connexion</a>
        <a href="inscription.php" class="btn btn-sm btn-primary">Inscription</a>
      <?php endif; ?>
    </div>
  </div>
</nav>
<div class="container">
