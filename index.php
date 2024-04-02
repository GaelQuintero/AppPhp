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
    <title>Index</title>
</head>
<body>
    <h1>Bienvenido al índice</h1>
    <p>Esta es la página principal de tu aplicación.</p>
    <p>Usuario autenticado: <?php echo $_SESSION['userInfoData']['name']; ?></p>
    <p>Email: <?php echo $_SESSION['userInfoData']['email']; ?></p>
    <img src="<?php echo $_SESSION['userInfoData']['picture']; ?>" alt="Profile Picture">
    <br>
    <a href="google_login.php?logout">Cerrar sesión</a>
</body>
</html>
