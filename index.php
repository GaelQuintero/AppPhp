<?php
require_once 'google_login.php';

// Verifica si el usuario está autenticado
if (!isset($_SESSION['access_token'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Us</title>
     <!--- Favicon --->
     <link rel="icon" type="image/x-icon" href="img/UTC_LOGO.png">
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-success">
  <div class="container-fluid">
    <a class="navbar-brand">Bienvenido al portal <?php echo $_SESSION['userInfoData']['name']; ?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="certificado.php">Certificacion</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="<?php echo $_SESSION['userInfoData']['picture']; ?>" alt="Profile Picture" class="img-fluid rounded-circle" style="max-height: 50px; margin-left: 10px;">
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item text-success" href="google_login.php?logout">Cerrar sesión</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="card">
  <div class="card-body text-success">
  Firmas y certificados digitales &nbsp 
  </div>
</div>

<div class="container mt-4">
    <h2 class="text-success">Registros Académicos</h2>
    <div class="row">
        <div class="col">
            <!-- Aquí puedes mostrar los registros académicos recuperados de la cadena de bloques -->
            <?php
            // Aquí deberías escribir el código PHP para interactuar con la blockchain y obtener los registros académicos del usuario
            // Por ejemplo, podrías usar una biblioteca PHP para interactuar con un contrato inteligente en una blockchain Ethereum
            // y recuperar los registros académicos del usuario autenticado
            ?>
            <div class="card">
                <div class="card-body">
                    <!-- Aquí deberías mostrar los registros académicos recuperados -->
                    <!-- Por ejemplo, podrías mostrar una tabla con los detalles de los registros académicos -->
                    <!-- <table class="table">
                        <thead>
                            <tr>
                                <th>Materia</th>
                                <th>Nota</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Matemáticas</td>
                                <td>90</td>
                            </tr>
                            <tr>
                                <td>Ciencias</td>
                                <td>85</td>
                            </tr>
                            <!-- Aquí podrías iterar sobre los registros académicos y mostrarlos en la tabla -->
                        </tbody>
                    </table> -->
                </div>
            </div>
        </div>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>
