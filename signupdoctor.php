<?php
include 'db.php';
$message = "";
$sp = $pdo->query("SELECT * FROM specialites")->fetchAll();
$villes = $pdo->query("SELECT * FROM ville")->fetchAll();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $ville_id = $_POST['ville_id'];
    $specialites_id = $_POST['specialites_id'];
    $role = 'docteur';
    $date_creation = date('Y-m-d', time());
    $nom = $_POST['nom'];
    $tel = $_POST['tel'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0){
        $message = "<div class='alert alert-danger'>Email déjà utilisé</div>";
    }else{
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (email, passcode, role, date_creation) VALUES (?, ?, ?, ?)");
        $stmt->execute([$email, $hashedPassword, $role, $date_creation]);
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $newUser = $stmt->fetch();
        $stmt = $pdo->prepare("INSERT INTO docteurs (nom, tel, specialites_id,ville_id, user_id) VALUES (?,?,?,?,?)");
        $stmt->execute([$nom, $tel, $specialites_id, $ville_id, $newUser['id']]);
        $message = "<div class='alert alert-success'>Compte créé avec succès</div>
        <script>
        setTimeout(function(){
        window.location.href = 'login.php';
        },1000)
        </script>
        ";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Création de Compte</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding: 0;
      min-height: 100vh;
      background: linear-gradient(135deg, #3a86ff, #8338ec);
      overflow-x: hidden;
      position: relative;
      color: white;
    }

    .background-shape {
      position: absolute;
      border-radius: 50%;
      opacity: 0.15;
      z-index: 0;
      animation: float 6s ease-in-out infinite;
    }

    .shape1 {
      width: 300px;
      height: 300px;
      top: -80px;
      left: -100px;
      background: #ffffff;
    }

    .shape2 {
      width: 200px;
      height: 200px;
      bottom: 40px;
      right: 20px;
      background: #ffd6ff;
      animation-delay: 2s;
    }

    @keyframes float {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(20px); }
    }

    .container {
      position: relative;
      z-index: 1;
    }

    .card-glass {
      background: rgba(255, 255, 255, 0.1);
      border: none;
      border-radius: 1.5rem;
      backdrop-filter: blur(10px);
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
      padding: 2rem;
      color: white;
    }

    .form-control, .form-select {
      background-color: rgba(255, 255, 255, 0.15);
      border: none;
      color: white;
    }

    .form-control::placeholder {
      color: rgba(255, 255, 255, 0.7);
    }

    .form-label {
      font-weight: 500;
    }

    .btn-primary {
      background-color: #3a86ff;
      border: none;
      font-weight: 600;
      transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
      background-color: #2f70d9;
    }

    a {
      color: #fff;
      text-decoration: underline;
    }

    a:hover {
      color: #ffd6ff;
    }

    /* Responsive padding */
    @media (max-width: 576px) {
      .card-glass {
        padding: 1.5rem 1.25rem;
      }
    }
  </style>
</head>
<body>

  <!-- Animated Background Shapes -->
  <div class="background-shape shape1"></div>
  <div class="background-shape shape2"></div>

  <div class="container d-flex align-items-center justify-content-center min-vh-100">
    <div class="col-md-8 col-lg-7">
      <div class="card card-glass shadow-sm rounded-4">
        <div class="card-body p-4">
          <h3 class="text-center mb-4">Créer un compte Docteur</h3>
          <?= $message ?>
          <form method="post" class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Adresse Email</label>
              <input type="email" name="email" class="form-control" placeholder="email@exemple.com" required />
            </div>
            <div class="col-md-6">
              <label class="form-label">Mot de passe</label>
              <input type="password" name="password" class="form-control" placeholder="********" required />
            </div>
            <div class="col-md-6">
              <label class="form-label">Nom Complet</label>
              <input type="text" name="nom" class="form-control" placeholder="Dr. Nom" required />
            </div>
            <div class="col-md-6">
              <label class="form-label">Téléphone</label>
              <input type="text" name="tel" class="form-control" placeholder="06XXXXXXXX" required />
            </div>
            <div class="col-md-6">
              <label class="form-label">Spécialité</label>
              <select name="specialites_id" class="form-select" required>
                <option value="">-- Sélectionner une spécialité --</option>
                <?php foreach($sp as $row): ?>
                  <option value="<?= $row['id'] ?>"><?= $row['nom'] ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Ville</label>
              <select name="ville_id" class="form-select" required>
                <option value="">-- Sélectionner une ville --</option>
                <?php foreach($villes as $ville): ?>
                  <option value="<?= $ville['id'] ?>"><?= $ville['nom'] ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-12 d-grid mt-3">
              <button type="submit" class="btn btn-primary">Créer le compte</button>
            </div>
            <div class="text-center mt-2">
              <a href="login.php" class="text-decoration-none">Login</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
