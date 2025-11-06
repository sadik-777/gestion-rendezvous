<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include "db.php";
include 'nav.php';
$message = '';
$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT d.id as idd, d.tel AS tel, d.nom AS nom, d.ville_id, s.nom AS specialite,v.id as idv, v.nom AS ville
    FROM docteurs d
    JOIN ville v ON d.ville_id = v.id
    JOIN specialites s ON s.id = d.specialites_id
    WHERE d.user_id = ?
");
$stmt->execute([$user_id]);
$docteurs = $stmt->fetch();
$filtre_ville = $docteurs["ville_id"];
$villes = $pdo->query("SELECT * FROM ville")->fetchAll();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = $_POST["nom"];
    $tel = $_POST["tel"];
    $ville = $_POST["ville"];
    $updatedcStmt = $pdo->prepare("UPDATE docteurs SET nom = ?, tel = ?, ville_id = ? WHERE user_id = ?");
    $updatedcStmt->execute([$nom, $tel, $ville, $user_id]);
    $message = "<div class='alert alert-success'> Modifie avec success</div>";
    $filtre_ville = $ville;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Mon Profil</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding: 0;
      min-height: 100vh;
      background: linear-gradient(135deg, #3a86ff, #8338ec);
      overflow-x: hidden;
      color: #fff;
      position: relative;
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
      top: -100px;
      left: -100px;
      background: #ffffff;
    }

    .shape2 {
      width: 200px;
      height: 200px;
      bottom: 50px;
      right: 30px;
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
      color: #fff;
    }

    .form-control::placeholder, .form-select option {
      color: rgba(255, 255, 255, 0.7);
    }

    .form-label {
      font-weight: 500;
    }

    .btn-primary {
      background-color: #3a86ff;
      border: none;
      font-weight: 600;
    }

    .btn-primary:hover {
      background-color: #2f70d9;
    }

    .btn-outline-secondary {
      color: #fff;
      border-color: #fff;
    }

    .btn-outline-secondary:hover {
      background-color: rgba(255, 255, 255, 0.15);
    }

    a {
      color: #fff;
    }

  </style>
</head>
<body>

<!-- Background Shapes -->
<div class="background-shape shape1"></div>
<div class="background-shape shape2"></div>

<div class="container d-flex align-items-center justify-content-center min-vh-100">
  <div class="col-md-8 col-lg-6">
    <div class="card card-glass">
      <h3 class="text-center mb-4">Mon Profil</h3>
      <form method="post">
        <?= $message ?>
        <div class="mb-3">
          <label for="nom" class="form-label">Nom</label>
          <input type="text" name="nom" id="nom" class="form-control" value="<?= htmlspecialchars($docteurs['nom']) ?>" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Téléphone</label>
          <input type="text" name="tel" class="form-control" value="<?= htmlspecialchars($docteurs['tel']) ?>" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Ville</label>
          <select name="ville" class="form-select">
            <option value="">-- Ville --</option>
            <?php foreach ($villes as $v): ?>
              <?php if (!is_numeric($v['nom'])): ?>
                <option value="<?= $v['id'] ?>" <?= $filtre_ville == $v['id'] ? 'selected' : '' ?>>
                  <?= htmlspecialchars($v['nom']) ?>
                </option>
              <?php endif; ?>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="d-flex justify-content-between mt-4">
          <a href="doctor.php" class="btn btn-outline-secondary">← Retour</a>
          <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>
      </form>
    </div>
  </div>
</div>

</body>
</html>
