<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include "db.php";

// Variables importantes
$id = $_GET['id']; // ID docteur
$idu = $_SESSION['user_id'];
$date = date('Y-m-d');
$messageV = "";
$hasRdvToday = false;

// Vérifier que $id est valide
if (!$id) {
    die("Docteur non spécifié.");
}

// Charger infos docteur
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

// Compter rendez-vous aujourd’hui (sans condition state)
$renderStmt = $pdo->query("SELECT count(*) as s FROM `rendezvous` WHERE  `docteurs_id` = $id AND state != 'Annulée' and date BETWEEN concat(CURRENT_DATE(),' 00:00:00') AND concat(CURRENT_DATE(),' 23:59:59')");
$renderV = $renderStmt->fetch();

// Récupérer patient connecté
$patientStmt = $pdo->prepare("SELECT id FROM patientes WHERE user_id = ?");
$patientStmt->execute([$idu]);
$patient = $patientStmt->fetch();

// Vérifier si patient a RDV aujourd’hui
if ($patient) {
    $checkStmt = $pdo->prepare("SELECT id FROM rendezvous
        WHERE docteurs_id = ? AND patientes_id = ? AND DATE(date) = ?
    ");
    $checkStmt->execute([$id, $patient['id'], $date]);
    if ($checkStmt->rowCount() > 0) {
        $hasRdvToday = true;
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $date_RendezV = $_POST["date"] ?? '';

    if ($patient && DateTime::createFromFormat('Y-m-d', $date_RendezV)) {
        $stmt = $pdo->prepare("SELECT id FROM rendezvous
            WHERE docteurs_id = ? AND patientes_id = ? AND DATE(date) = ?
        ");
        $stmt->execute([$id, $patient['id'], $date_RendezV]);

        if ($stmt->rowCount() === 0) {
            try {
                $rnv = $pdo->prepare("INSERT INTO rendezvous (date, patientes_id, docteurs_id) VALUES (?, ?, ?)");
                $success = $rnv->execute([$date_RendezV . ' 00:00:00', $patient['id'], $id]);

                if ($success) {
                    $messageV = "<div class='alert alert-success mt-3'>Rendez-vous confirmé avec succès</div>";
                    if ($date_RendezV === $date) {
                        $hasRdvToday = true;
                        $renderStmt->execute([$id, $date]);
                        $renderV = $renderStmt->fetch();
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
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Docteur</title>
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #f8f9fa;
        }
        .doctor-card {
            max-width: 700px;
            margin: auto;
        }
        .doctor-img {
            width: 160px;
            height: 160px;
            object-fit: cover;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="card shadow-lg rounded-4 doctor-card p-4 bg-white">
        <div class="row g-4 align-items-center">
            <div class="col-md-4 text-center">
                <img src="doctor-svgrepo-com (2).svg" alt="Photo docteur" class="img-fluid rounded-circle border doctor-img" />
            </div>
            <div class="col-md-8">
                <h3 class="fw-bold"><?= htmlspecialchars($doctors['nom']) ?></h3>
                <h6 class="text-primary mb-3"><strong>Spécialité :</strong> <?= htmlspecialchars($doctors['specialite']) ?></h6>
                <ul class="list-unstyled mb-4">
                    <li><strong>Ville :</strong> <?= htmlspecialchars($doctors['ville']) ?></li>
                    <li><strong>Téléphone :</strong> <?= htmlspecialchars($doctors['tel']) ?></li>
                    <li><strong>Total rendez-vous aujourd’hui :</strong> <?= htmlspecialchars($renderV['s']) ?></li>
                </ul>

                <!-- Message de confirmation / erreur -->
                <?= $messageV ?>

                <div class="d-flex gap-2">
                    <a href="patient.php" class="btn btn-outline-secondary">← Retour à la liste</a>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#rdvModal" <?= $hasRdvToday ? 'disabled' : '' ?>>
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
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rdvModalLabel">Formulaire de Rendez-vous</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" id="date" name="date" class="form-control" required />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
