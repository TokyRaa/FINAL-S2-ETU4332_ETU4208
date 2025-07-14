<?php
include __DIR__ . '/../inc/config.php';

// Si aucune catégorie, retour au filtre
if (empty($_GET['categorie'])) {
    header('Location: ../pages/filtre.php');
    exit;
}

$idCat = (int) $_GET['categorie'];
// Vérifie l’existence de la catégorie
$stmtC = $pdo->prepare("SELECT nom_categorie FROM categorie_objet WHERE id_categorie = ?");
$stmtC->execute([$idCat]);
$categ = $stmtC->fetchColumn();
if (!$categ) {
    header('Location: filtre.php');
    exit;
}

// Récupère les objets
$sql = "
  SELECT o.id_objet, o.nom_objet, m.nom AS proprio,
         e.date_emprunt, e.date_retour
    FROM objet o
    JOIN membre m ON o.id_membre = m.id_membre
    LEFT JOIN emprunt e
      ON o.id_objet = e.id_objet
     AND e.date_retour IS NULL
   WHERE o.id_categorie = :cat
   ORDER BY o.nom_objet
";
$stmt = $pdo->prepare($sql);
$stmt->execute(['cat' => $idCat]);
$objets = $stmt->fetchAll();

include __DIR__ . '/../inc/header.php';
?>

<h2>Objets – catégorie « <?= htmlspecialchars($categ) ?> »</h2>
<p><a href="filtre.php" class="btn btn-link">&larr; Changer de catégorie</a></p>

<?php if (empty($objets)): ?>
  <div class="alert alert-info">Aucun objet dans cette catégorie.</div>
<?php else: ?>
  <div class="row row-cols-1 row-cols-md-3 g-4">
    <?php foreach($objets as $o): ?>
      <div class="col">
        <div class="card h-100">
          <img src="../assets/uploads/<?= $o['id_objet'] ?>.jpg"
               onerror="this.src='../assets/uploads/default.png';"
               class="card-img-top" alt="<?= htmlspecialchars($o['nom_objet']) ?>">
          <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($o['nom_objet']) ?></h5>
            <p class="card-text">
              Propriétaire : <?= htmlspecialchars($o['proprio']) ?><br>
              <?php if ($o['date_emprunt']): ?>
                <span class="badge bg-warning text-dark">
                  Emprunté depuis <?= htmlspecialchars($o['date_emprunt']) ?>
                </span>
              <?php else: ?>
                <span class="badge bg-success">Disponible</span>
              <?php endif; ?>
            </p>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<?php include __DIR__ . '/../inc/footer.php'; ?>
