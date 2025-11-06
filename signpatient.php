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
        $message = "<div class='alert alert-success'>Compte créé avec succès</div>
        <script>
        setTimeout(function(){
            window.location.href = 'login.php';
        }, 1000); 
    </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Créer un compte Patient</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="css/bootstrap.min.css" rel="stylesheet" />
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

    /* Responsive fixes */
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
    <div class="col-md-8 col-lg-6">
      <div class="card card-glass">
        <h3 class="text-center mb-4">Créer un compte Patient</h3>
        <?= $message ?>
        <form method="post" class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Adresse Email</label>
            <input type="email" name="email" class="form-control" placeholder="exemple@domaine.com" required />
          </div>
          <div class="col-md-6">
            <label class="form-label">Mot de passe</label>
            <input type="password" name="password" class="form-control" placeholder="********" required />
          </div>
          <div class="col-md-6">
            <label class="form-label">Nom</label>
            <input type="text" name="nom" class="form-control" placeholder="Nom" required />
          </div>
          <div class="col-md-6">
            <label class="form-label">Prénom</label>
            <input type="text" name="prenom" class="form-control" placeholder="Prénom" required />
          </div>
          <div class="col-md-6">
            <label class="form-label">Téléphone</label>
            <input type="text" name="tel" class="form-control" placeholder="06XXXXXXXX" required />
          </div>
          <div class="col-md-6">
            <label class="form-label">Date de naissance</label>
            <input type="date" name="date_naissance" class="form-control" required />
          </div>
          <div class="col-12 d-grid mt-3">
            <button type="submit" class="btn btn-primary">Créer le compte</button>
          </div>
          <div class="text-center mt-2">
            <a href="login.php">Login</a>
          </div>
        </form>
      </div>
    </div>
  </div>

</body>
</html>

