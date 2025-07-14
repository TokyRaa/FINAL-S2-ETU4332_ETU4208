<?php
require_once __DIR__ . '/../inc/config.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $mdp   = $_POST['mdp'];

    $stmt = $pdo->prepare("SELECT * FROM membre WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user && password_verify($mdp, $user['mdp'])) {
        $_SESSION['membre'] = [
          'id_membre' => $user['id_membre'],
          'nom'       => $user['nom']
        ];
        header('Location: filtre.php');
        exit;
    }
    $error = "Email ou mot de passe invalide.";
}

include __DIR__ . '/../inc/header.php';
?>

<h2>Connexion</h2>
<?php if ($error): ?>
  <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>
<form method="post" class="mx-auto" style="max-width:400px;">
  <div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Mot de passe</label>
    <input type="password" name="mdp" class="form-control" required>
  </div>
  <button class="btn btn-primary w-100">Se connecter</button>
</form>

<?php include __DIR__ . '/../inc/footer.php'; ?>
