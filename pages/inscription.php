<?php
require_once __DIR__ . '/../inc/config.php';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom    = trim($_POST['nom']);
    $email  = trim($_POST['email']);
    $mdp    = $_POST['mdp'];
    $ville  = trim($_POST['ville']);
    $genre  = $_POST['genre'];
    $dnaiss = $_POST['date_naissance'];

    if (!$nom || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($mdp) < 6) {
        $errors[] = "Champs invalides ou manquants.";
    }

    $imgName = null;
    if (!empty($_FILES['image_profil']['name'])) {
        $ext = pathinfo($_FILES['image_profil']['name'], PATHINFO_EXTENSION);
        $imgName = uniqid('img_') . ".$ext";
        move_uploaded_file($_FILES['image_profil']['tmp_name'], "../assets/uploads/$imgName");
    }

    if (!$errors) {
        $stmt = $pdo->prepare("
          INSERT INTO membre (nom,date_naissance,genre,email,ville,mdp,image_profil)
          VALUES (:nom,:dn,:genre,:email,:ville,:mdp,:img)
        ");
        $stmt->execute([
          'nom'=>$nom,'dn'=>$dnaiss,'genre'=>$genre,
          'email'=>$email,'ville'=>$ville,
          'mdp'=>password_hash($mdp,PASSWORD_DEFAULT),
          'img'=>$imgName
        ]);
        header('Location: login.php');
        exit;
    }
}

include __DIR__ . '/../inc/header.php';
?>

<h2>Inscription</h2>
<?php if($errors): ?>
  <div class="alert alert-danger"><?= implode('<br>',$errors) ?></div>
<?php endif; ?>
<form method="post" enctype="multipart/form-data">
  <div class="mb-3"><label>Nom</label><input name="nom" class="form-control" required></div>
  <div class="mb-3"><label>Date de naissance</label><input type="date" name="date_naissance" class="form-control" required></div>
  <div class="mb-3">
    <label>Genre</label>
    <select name="genre" class="form-select" required>
      <option value="M">Homme</option>
      <option value="F">Femme</option>
      <option value="Autre">Autre</option>
    </select>
  </div>
  <div class="mb-3"><label>Email</label><input type="email" name="email" class="form-control" required></div>
  <div class="mb-3"><label>Ville</label><input name="ville" class="form-control"></div>
  <div class="mb-3"><label>Mot de passe</label><input type="password" name="mdp" class="form-control" required></div>
  <div class="mb-3"><label>Photo profil</label><input type="file" name="image_profil" class="form-control"></div>
  <button class="btn btn-primary">S’inscrire</button>
</form>

<?php include __DIR__ . '/../inc/footer.php'; ?>
