<?php
session_start();
include 'db.php';
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    

    if ($user && password_verify($password, $user['passcode'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_role'] = $user['role'];
        if($user['role'] == 'patient'){
            header("Location: patient.php");
        }else if($user['role'] == 'docteur'){
            header("Location: doctor.php");
        }
        exit;
    } else {
        $message = "<div class='alert alert-danger'>Email ou mot de passe incorrect</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
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

    .form-control {
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
  </style>
</head>
<body>

<div class="background-shape shape1"></div>
<div class="background-shape shape2"></div>

<div class="container d-flex align-items-center justify-content-center min-vh-100">
  <div class="col-md-6 col-lg-5">
    <div class="card card-glass">
      <h3 class="text-center mb-4">Connexion</h3>
      <?= $message ?>
      <form method="post">
        <div class="mb-3">
          <label for="email" class="form-label">Adresse e-mail</label>
          <input type="email" name="email" id="email" class="form-control" placeholder="exemple@domaine.com" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Mot de passe</label>
          <input type="password" name="password" id="password" class="form-control" placeholder="********" required>
        </div>
        <div class="d-grid mb-3">
          <button type="submit" class="btn btn-primary">Se connecter</button>
        </div>
        <div class="text-center">
          <a href="signup.php">Créer un compte</a>
        </div>
      </form>
    </div>
  </div>
</div>

</body>
</html>
