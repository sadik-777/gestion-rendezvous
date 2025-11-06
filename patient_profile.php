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

$stmt = $pdo->prepare("SELECT * FROM patientes WHERE user_id = ?");
$stmt->execute([$user_id]);
$patiente = $stmt->fetch();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];

    $updateStmt = $pdo->prepare("UPDATE patientes SET nom = ?, prenom = ? WHERE user_id = ?");
    $updateStmt->execute([$nom,$prenom, $user_id]);
    $message = "<div class='alert alert-success'> Modifie avec success</div>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mon Profil</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5 d-flex justify-content-center">
    <div class="card shadow rounded-4 p-4" style="width: 100%; max-width: 600px;">
        <h3 class="text-center mb-4">Mon Profil</h3>
        <form method="post">
            <?= $message ?>
            <div class="mb-3">
                <label for="nom" class="form-label fw-bold">Nom</label>
                <input type="text" name="nom" id="nom" class="form-control" value="<?= htmlspecialchars($patiente['nom']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="prenom" class="form-label fw-bold">Prénom</label>
                <input type="text" name="prenom" id="prenom" class="form-control" value="<?= htmlspecialchars($patiente['prenom']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Téléphone</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($patiente['tel']) ?>" disabled>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Date de naissance</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($patiente['date_naissance']) ?>" disabled>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="patient.php" class="btn btn-outline-secondary">
                    ← Retour à la liste
                </a>
                <button type="submit" class="btn btn-primary">
                    Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
