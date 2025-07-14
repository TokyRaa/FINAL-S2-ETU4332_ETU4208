<?php
require_once __DIR__ . '/../inc/config.php';

if (empty($_GET['categorie'])) {
    header('Location: filtre.php');
    exit;
}
$idCat = (int) $_GET['categorie'];

// Vérifie la catégorie
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
         e.date_emprunt
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

<section class="mb-4">
  <h2 class="fw-bold">Catégorie : <?= htmlspecialchars($categ) ?></h2>
  <a href="filtre.php" class="text-decoration-none">&larr; Changer de catégorie</a>
</section>

<?php if (empty($objets)): ?>
  <div class="alert alert-info">Aucun objet disponible dans cette catégorie.</div>
<?php else: ?>
  <div class="row g-4">
    <?php foreach($objets as $o): ?>
      <div class="col-sm-6 col-lg-4">
        <div class="card">
          <img src="../assets/uploads/<?= $o['id_objet'] ?>.jpeg"
               onerror="this.src='../assets/uploads/default.jpeg';"
               class="card-img-top"
               alt="<?= htmlspecialchars($o['nom_objet']) ?>">
          <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($o['nom_objet']) ?></h5>
            <p class="card-text mb-1">Propriétaire : <?= htmlspecialchars($o['proprio']) ?></p>
            <?php if ($o['date_emprunt']): ?>
              <span class="badge bg-warning text-dark">Emprunté</span>
            <?php else: ?>
              <span class="badge bg-success">Disponible</span>
            <?php endif; ?>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<?php include __DIR__ . '/../inc/footer.php'; ?>
