<?php 
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
include "db.php";
include "nav1.php";
?>
<?php
$idu = $_SESSION["user_id"];
$stmt = $pdo->prepare("SELECT d.id as idd, d.tel AS tel, d.nom AS nom, s.nom AS specialite, v.nom AS ville
    FROM docteurs d
    JOIN ville v ON d.ville_id = v.id
    JOIN specialites s ON s.id = d.specialites_id
    WHERE d.user_id = ?
");
$stmt->execute([$idu]);
$docteurs = $stmt->fetch();
$idd = $docteurs['idd'];
$renderStmt = $pdo->query("SELECT count(*) as s FROM `rendezvous` WHERE  `docteurs_id` = $idd AND state != 'Annulée' and date BETWEEN concat(CURRENT_DATE(),' 00:00:00') AND concat(CURRENT_DATE(),' 23:59:59')");
$renderV = $renderStmt->fetch();
$renderSt = $pdo->query("SELECT COUNT(*) as s FROM `rendezvous` WHERE docteurs_id = $idd");
$renderTOTAL = $renderSt->fetch();



?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard Docteur</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding: 0;
      color: #fff;
      position: relative;
      min-height: 100vh;
      background: linear-gradient(135deg, #3a86ff, #8338ec);
      overflow-x: hidden;
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
      0%, 100% { transform: translateY(0px); }
      50% { transform: translateY(20px); }
    }

    .container {
      position: relative;
      z-index: 1;
    }

    .dashboard-header {
      background-color: rgba(255, 255, 255, 0.1);
      border-radius: 1rem;
      padding: 2rem;
      margin-bottom: 2rem;
      box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }

    .card-custom {
      border: none;
      border-radius: 1rem;
      padding: 1.5rem;
      color: white;
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
      box-shadow: 0 6px 20px rgba(0,0,0,0.2);
      transition: transform 0.3s ease;
    }

    .card-custom:hover {
      transform: translateY(-5px);
    }

    .card-title {
      font-size: 1rem;
      opacity: 0.85;
    }

    .card-text {
      font-size: 2rem;
      font-weight: 600;
    }
  </style>
</head>
<body>

<div class="background-shape shape1"></div>
<div class="background-shape shape2"></div>

<div class="container mt-5">
    <div class="dashboard-header text-white">
    <h3>Bienvenue Dr. <?= htmlspecialchars($docteurs["nom"]) ?></h3>
    </div>

    <div class="row g-4">
    <div class="col-md-4">
        <div class="card-custom">
        <h5 class="card-title">Rendez-vous aujourd’hui</h5>
        <p class="card-text"><?= htmlspecialchars($renderV['s']) ?></p>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card-custom">
        <h5 class="card-title">Spécialité</h5>
        <p class="card-text"><?= htmlspecialchars($docteurs["specialite"]) ?></p>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card-custom">
        <h5 class="card-title">Ville</h5>
        <p class="card-text"><?= htmlspecialchars($docteurs["ville"]) ?></p>
        </div>
    </div>
    </div>
    <div class="col-md-4 mt-4">
        <div class="card-custom">
        <h5 class="card-title">Total Rendez-vous</h5>
        <p class="card-text"><?= htmlspecialchars($renderTOTAL["s"]) ?></p>
        </div>
    </div>
    </div>
</div>

</body>
</html>
