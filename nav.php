<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Bootstrap Navbar</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-success">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">RendezVous</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a href="logout.php" class="nav-link active" aria-current="page">Déconnexion</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="patient_profile.php">Profile</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
