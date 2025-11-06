<?php
include 'db.php';
$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = 'patient';
    $date_creation = date('Y-m-d', time());
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $tel = $_POST['tel'];
    $date_naissance = $_POST['date_naissance'];
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
        $stmt = $pdo->prepare("INSERT INTO patientes (nom, prenom, tel, date_naissance,user_id) VALUES (?,?,?,?,?)");
        $stmt->execute([$nom, $prenom, $tel, $date_naissance, $newUser['id']]);
        $message = "<div class='alert alert-success'>Compte créé avec succès</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Créer un Compte</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(20px); }
    }

    .container {
      position: relative;
      z-index: 1;
    }

    .selection-header {
      background-color: rgba(255, 255, 255, 0.1);
      border-radius: 1rem;
      padding: 2rem;
      margin-bottom: 3rem;
      text-align: center;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .option-card {
      background: rgba(255, 255, 255, 0.1);
      border-radius: 1rem;
      padding: 2rem;
      color: white;
      backdrop-filter: blur(10px);
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
      text-align: center;
      transition: transform 0.3s ease;
      text-decoration: none;
    }

    .option-card:hover {
      transform: translateY(-5px);
    }

    .option-img {
      width: 100px;
      height: 100px;
      object-fit: contain;
      margin-bottom: 1rem;
    }

    .option-title {
      font-size: 1.2rem;
      font-weight: 600;
      margin-top: 0.5rem;
    }

    a.option-card {
      text-decoration: none;
      color: inherit;
    }
  </style>
</head>
<body>

<!-- Background Shapes -->
<div class="background-shape shape1"></div>
<div class="background-shape shape2"></div>

<div class="container py-5">
  <?php if (!empty($message)) echo $message; ?>
  
  <div class="selection-header text-white">
    <h2 class="mb-3">Créer un compte</h2>
    <p class="lead mb-0">Choisissez votre type de compte</p>
  </div>

  <div class="row justify-content-center g-4">
    <div class="col-md-5">
      <a href="signupdoctor.php" class="option-card d-block">
        <img src="doctor-svgrepo-com.svg" alt="Docteur" class="option-img">
        <div class="option-title">Je suis un docteur</div>
      </a>
    </div>
    <div class="col-md-5">
      <a href="signpatient.php" class="option-card d-block">
        <img src="doctor-svgrepo-com (1).svg" alt="Patient" class="option-img">
        <div class="option-title">Je suis un patient</div>
      </a>
    </div>
  </div>
</div>

</body>
</html>
