<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include "db.php";
include "nav.php";
$id = $_GET['id']; 
$idu = $_SESSION['user_id'];
$date = date('Y-m-d');
$messageV = "";
$hasRdvToday = false;


$stmt = $pdo->prepare("SELECT d.id, d.tel AS tel, d.nom AS nom, s.nom AS specialite, v.nom AS ville
    FROM docteurs d
    JOIN ville v ON d.ville_id = v.id
    JOIN specialites s ON s.id = d.specialites_id
    WHERE d.id = ?
");
$stmt->execute([$id]);
$doctors = $stmt->fetch();

if (!$doctors) {
    die("Docteur introuvable.");
}

$renderStmt = $pdo->query("SELECT count(*) as s FROM `rendezvous` WHERE  `docteurs_id` = $id AND state != 'Annulée' and date BETWEEN concat(CURRENT_DATE(),' 00:00:00') AND concat(CURRENT_DATE(),' 23:59:59')");
$renderV = $renderStmt->fetch();

$patientStmt = $pdo->prepare("SELECT id FROM patientes WHERE user_id = ?");
$patientStmt->execute([$idu]);
$patient = $patientStmt->fetch();

if ($patient) {
    $checkStmt = $pdo->prepare("SELECT COUNT(*) as nb FROM `rendezvous` WHERE docteurs_id = ? AND patientes_id = ? AND date BETWEEN CONCAT(CURRENT_DATE(), ' 00:00:00') and concat(CURRENT_DATE(), ' 23:59:59')");
    $checkStmt->execute([$id, $patient['id']]);
    $test = $checkStmt->fetch();
    if ($test['nb'] > 0) {
        $hasRdvToday = true;
    }
}

if (isset($_POST["add"])) {
    $date_RendezV = '';
    $date_RendezV = $_POST["date"] ?? '';
    if ($patient) {
        $stmt = $pdo->prepare("SELECT id FROM rendezvous
            WHERE docteurs_id = ? AND patientes_id = ? AND DATE(date) = ?
        ");
        $stmt->execute([$id, $patient['id'], $date_RendezV]);

        if ($stmt->rowCount() === 0) {
            try {
                $rnv = $pdo->prepare("INSERT INTO rendezvous (date, patientes_id, docteurs_id) VALUES (?, ?, ?)");
                $success = $rnv->execute([$date_RendezV, $patient['id'], $id]);

                if ($success) {
                    $messageV = "<div class='alert alert-success mt-3'>Rendez-vous confirmé avec succès</div>";
                    if ($date_RendezV === $date) {
                        $hasRdvToday = true;
                    }
                } else {
                    $messageV = "<div class='alert alert-danger mt-3'>Erreur lors de la prise du rendez-vous.</div>";
                }
            } catch (PDOException $e) {
                $messageV = "<div class='alert alert-danger mt-3'>Erreur : " . htmlspecialchars($e->getMessage()) . "</div>";
            }
        } else {
            $messageV = "<div class='alert alert-warning mt-3'>Vous avez déjà un rendez-vous à cette date.</div>";
        }
    } else {
        $messageV = "<div class='alert alert-danger mt-3'>Date invalide.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8" /><title>Profil Docteur</title><meta name="viewport" content="width=device-width, initial-scale=1" />
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
      max-width: 700px;
      margin: auto;
    }

    .doctor-img {
      width: 200px;
      height: 200px;
      object-fit: cover;
      border-radius: 50%;
      border: 3px solid rgba(255 255 255 / 0.7);
      padding: 0.25rem;
    }

    h1, h3 {
      font-weight: 600;
    }

    .info-card {
      background: rgba(255 255 255 / 0.15);
      border-radius: 1rem;
      box-shadow: 0 4px 12px rgb(0 0 0 / 0.2);
      padding: 1rem 0;
      text-align: center;
      transition: background-color 0.3s ease;
      cursor: default;
    }

    .info-card h5 {
      margin-bottom: 0.5rem;
      font-weight: 600;
      color: #fff;
    }

    .info-card p {
      font-size: 1.5rem;
      margin: 0;
      color: #fff;
    }

    .info-primary {
      background-color: #3a86ff;
    }
    .info-warning {
      background-color: #ffb703;
    }
    .info-success {
      background-color: #80b918;
    }
    .info-danger {
      background-color: #d90429;
    }

    .btn-outline-light {
      color: white;
      border-color: white;
      transition: background-color 0.3s ease, color 0.3s ease;
    }
    .btn-outline-light:hover {
      background-color: rgba(255 255 255 / 0.2);
      color: white;
    }

    .btn-success {
      background-color: #80b918;
      border: none;
      font-weight: 600;
      transition: background-color 0.3s ease;
    }
    .btn-success:hover {
      background-color: #669f0d;
    }

    .modal-content {
      background: rgba(255 255 255 / 0.1);
      border-radius: 1rem;
      backdrop-filter: blur(10px);
      border: none;
      color: white;
    }

    .modal-header .btn-close {
      filter: brightness(10);
    }

    .form-label, .form-control {
      color: white;
    }
    .form-control, .form-select {
      background-color: rgba(255 255 255 / 0.15);
      border: none;
    }
    .form-control::placeholder {
      color: rgba(255 255 255 / 0.7);
    }
  </style>
</head>
<body>

  <div class="background-shape shape1"></div>
  <div class="background-shape shape2"></div>

  <div class="container py-5">
    <div class="card card-glass shadow-sm rounded-4">
      <div class="row g-5 align-items-center">
        <div class="col-md-4 text-center">
          <img src="doctor-svgrepo-com (2).svg" alt="Photo docteur" class="doctor-img" />
        </div>
        <div class="col-md-8">
          <h1><?= htmlspecialchars($doctors['nom']) ?></h1>
        </div>
      </div>

      <div class="row g-4 mt-5 text-center">
        <div class="col-md-4">
          <div class="info-card info-primary">
            <h5>Spécialité</h5>
            <p><?= htmlspecialchars($doctors['specialite']) ?></p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="info-card info-warning">
            <h5>Téléphone</h5>
            <p><?= htmlspecialchars($doctors['tel']) ?></p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="info-card info-success">
            <h5>Ville</h5>
            <p><?= htmlspecialchars($doctors['ville']) ?></p>
          </div>
        </div>
      </div>

      <div class="row mt-5">
        <div class="col-12">
          <div class="info-card info-danger mb-4">
            <h5>Total rendez-vous aujourd’hui</h5>
            <p><?= htmlspecialchars($renderV['s']) ?></p>
          </div>
          <?= $messageV ?>
          <div class="d-flex flex-wrap gap-3 justify-content-center">
            <a href="patient.php" class="btn btn-outline-light">
              ← Retour à la liste
            </a>
            <?php $disableBtn = $hasRdvToday || $renderV['s'] >= 20; ?>
            <button type="button" class="btn btn-success"
                    name="rdvModal"
                    data-bs-toggle="modal"
                    data-bs-target="#rdvModal"
                    <?= $disableBtn ? 'disabled' : '' ?>>
              Prendre Rendez-vous
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="rdvModal" tabindex="-1" aria-labelledby="rdvModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form method="post">
        <div class="modal-content rounded-4">
          <div class="modal-header">
            <h5 class="modal-title" id="rdvModalLabel">Formulaire de Rendez-vous</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
          </div>
          <div class="modal-body">
            <label for="date" class="form-label">Date</label>
            <input type="datetime-local" id="date" name="date" class="form-control" required />
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-light rounded-4" data-bs-dismiss="modal">Annuler</button>
            <button type="submit" name="add" class="btn btn-success rounded-4">Envoyer</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>


