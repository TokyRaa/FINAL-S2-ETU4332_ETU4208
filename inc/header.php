<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>EmpruntObjets</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="filtre.php">EmpruntObjets</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ms-auto">
        <?php if(!empty($_SESSION['membre'])): ?>
          <li class="nav-item me-3">
            <span class="nav-link">Salut, <?= htmlspecialchars($_SESSION['membre']['nom']) ?></span>
          </li>
          <li class="nav-item">
            <a class="btn btn-outline-danger btn-sm" href="logout.php">Déconnexion</a>
          </li>
        <?php else: ?>
          <li class="nav-item me-2">
            <a class="btn btn-outline-primary btn-sm" href="login.php">Connexion</a>
          </li>
          <li class="nav-item">
            <a class="btn btn-primary btn-sm" href="inscription.php">Inscription</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<div class="container my-5">
