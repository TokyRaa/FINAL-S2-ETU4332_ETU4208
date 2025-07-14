<?php
require_once __DIR__ . '/../inc/config.php';

// Récupère toutes les catégories
$cats = $pdo->query("SELECT * FROM categorie_objet ORDER BY nom_categorie")->fetchAll();

include __DIR__ . '/../inc/header.php';
?>

<h2>Filtrer par catégorie</h2>
<form method="get" action="liste_objets.php" class="row g-3 mb-4">
  <div class="col-md-6">
    <label for="categorie" class="form-label">Choisissez une catégorie :</label>
    <select name="categorie" id="categorie" class="form-select" required>
      <option value="" disabled selected>-- Sélectionner --</option>
      <?php foreach($cats as $cat): ?>
        <option value="<?= $cat['id_categorie'] ?>">
          <?= htmlspecialchars($cat['nom_categorie']) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="col-auto align-self-end">
    <button type="submit" class="btn btn-primary">Voir les objets</button>
  </div>
</form>

<?php include __DIR__ . '/../inc/footer.php'; ?>
