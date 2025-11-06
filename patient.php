<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
include "db.php";
include "nav.php";

$filtre_ville = $_GET['ville'] ?? '';
$filtre_specialite = $_GET['specialite'] ?? '';

$par_page = 6;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $par_page;

$sql_count = "SELECT COUNT(*) FROM docteurs d
    JOIN ville v ON d.ville_id = v.id
    JOIN specialites s ON d.specialites_id = s.id";
$params_count = [];

if ($filtre_ville) {
    $sql_count .= " AND v.id = ?";
    $params_count[] = $filtre_ville;
}
if ($filtre_specialite) {
    $sql_count .= " AND s.id = ?";
    $params_count[] = $filtre_specialite;
}
$stmt_count = $pdo->prepare($sql_count);
$stmt_count->execute($params_count);
$total = $stmt_count->fetchColumn();
$total_pages = ceil($total / $par_page);

$sql = "SELECT d.id, d.nom, d.tel, s.nom AS specialite, v.nom AS ville
    FROM docteurs d
    JOIN ville v ON d.ville_id = v.id
    JOIN specialites s ON d.specialites_id = s.id";
$params = [];

if ($filtre_ville) {
    $sql .= " AND v.id = ?";
    $params[] = $filtre_ville;
}
if ($filtre_specialite) {
    $sql .= " AND s.id = ?";
    $params[] = $filtre_specialite;
}

$sql .= " ORDER BY d.nom ASC LIMIT $par_page OFFSET $offset";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$docteurs = $stmt->fetchAll();

$villes = $pdo->query("SELECT * FROM ville")->fetchAll();
$specialites = $pdo->query("SELECT * FROM specialites")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
    <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #3a86ff, #8338ec);
      min-height: 100vh;
      overflow-x: hidden;
      color: #fff;
      position: relative;
      margin: 0;
      padding-bottom: 3rem;
    }

    .background-shape {
      position: absolute;
      border-radius: 50%;
      opacity: 0.1;
      z-index: 0;
      animation: float 6s ease-in-out infinite;
    }

    .shape1 {
      width: 250px;
      height: 250px;
      top: -100px;
      left: -100px;
      background: #ffffff;
    }

    .shape2 {
      width: 200px;
      height: 200px;
      bottom: 0;
      right: 30px;
      background: #ffd6ff;
      animation-delay: 2s;
    }

    @keyframes float {
      0%, 100% { transform: translateY(0px); }
      50% { transform: translateY(120px); }
    }

    .container {
      position: relative;
      z-index: 1;
    }

    .filter-box {
      background-color: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(6px);
      border-radius: 1rem;
      padding: 2rem;
      margin-top: 3rem;
      box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }

    .card-doctor {
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(12px);
      border-radius: 1rem;
      box-shadow: 0 6px 20px rgba(0,0,0,0.2);
      color: white;
      padding: 1.5rem;
      transition: transform 0.3s ease;
    }

    .card-doctor:hover {
      transform: translateY(-5px);
    }

    .doctor-img {
      width: 120px;
      height: 120px;
      object-fit: cover;
      border-radius: 50%;
      border: 3px solid #fff;
    }

    .pagination .page-link {
      background-color: rgba(255,255,255,0.1);
      color: white;
      border: none;
    }

    .pagination .active .page-link {
      background-color: #fff;
      color: #8338ec;
      font-weight: bold;
    }

    a.btn-success {
      background-color: #06d6a0;
      border: none;
    }
  </style>
</head>
<body>

<div class="background-shape shape1"></div>
<div class="background-shape shape2"></div>

<div class="container">
  <form method="get" class="row g-3 filter-box">
    <div class="col-md-4">
      <select name="ville" class="form-select">
        <option value="">-- Ville --</option>
        <?php foreach ($villes as $v): ?>
          <option value="<?= $v['id'] ?>" <?= $filtre_ville == $v['id'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($v['nom']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-4">
      <select name="specialite" class="form-select">
        <option value="">-- Spécialité --</option>
        <?php foreach ($specialites as $s): ?>
          <option value="<?= $s['id'] ?>" <?= $filtre_specialite == $s['id'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($s['nom']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-4 d-flex gap-2">
      <button class="btn btn-light">Rechercher</button>
      <a href="patient.php" class="btn btn-outline-light">Réinitialiser</a>
    </div>
  </form>

  <div class="my-5">
    <?php if (count($docteurs)): ?>
      <div class="row row-cols-1 row-cols-md-2 g-4">
        <?php foreach ($docteurs as $d): ?>
          <div class="col">
            <div class="card-doctor">
              <div class="row g-3 align-items-center">
                <div class="col-md-4 text-center">
                  <img src="doctor-svgrepo-com (2).svg" alt="Photo docteur" class="doctor-img">
                </div>
                <div class="col-md-8">
                  <h5 class="fw-bold mb-1"><?= htmlspecialchars($d['nom']) ?></h5>
                  <p class="mb-1"><strong>Spécialité:</strong> <?= htmlspecialchars($d['specialite']) ?></p>
                  <p class="mb-1"><strong>Ville:</strong> <?= htmlspecialchars($d['ville']) ?></p>
                  <p class="mb-2"><strong>Téléphone:</strong> <?= htmlspecialchars($d['tel']) ?></p>
                  <a href="profile.php?id=<?= $d['id'] ?>" class="btn btn-success btn-sm">Voir Profil</a>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <p class="text-center">Aucun docteur trouvé.</p>
    <?php endif; ?>
  </div>

  <?php if ($total_pages > 1): ?>
    <nav class="d-flex justify-content-center">
      <ul class="pagination">
        <?php $base_url = "patient.php?ville=" . urlencode($filtre_ville) . "&specialite=" . urlencode($filtre_specialite); ?>
        <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
          <a class="page-link" href="<?= $base_url . '&page=' . ($page - 1) ?>">«</a>
        </li>
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
          <li class="page-item <?= $i == $page ? 'active' : '' ?>">
            <a class="page-link" href="<?= $base_url . '&page=' . $i ?>"><?= $i ?></a>
          </li>
        <?php endfor; ?>
        <li class="page-item <?= $page >= $total_pages ? 'disabled' : '' ?>">
          <a class="page-link" href="<?= $base_url . '&page=' . ($page + 1) ?>">»</a>
        </li>
      </ul>
    </nav>
  <?php endif; ?>
</div>

</body>
</html>
