<?php
// Incluir el archivo que contiene la clase ConexionDB
require_once 'DB/conexiondb.php';

// Instanciar la clase ConexionDB para obtener la conexión a la base de datos
$conexionDB = new ConexionDB();
$conexion = $conexionDB->getConnection();

// Verificar la conexión
if (!$conexion) {
    die("Error de conexión: " . $conexionDB->errorInfo()[2]); // Obtener el mensaje de error
}

// Si se envía el formulario de registro
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar la entrada del usuario
    $nombreUsuario = htmlspecialchars($_POST['nombreUsuario']);

    // Preparar la consulta SQL para insertar el nuevo usuario en la tabla 'usuarios'
    $sql = "INSERT INTO usuarios (nombre_usuario) VALUES (:nombreUsuario)";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':nombreUsuario', $nombreUsuario);

    // Ejecutar la consulta preparada
    if ($stmt->execute()) {
        $idUsuario = $conexion->lastInsertId(); // Obtener el ID del último usuario insertado

        // Obtener la fecha actual
        $fechaConcesion = date('Y-m-d');

        // Preparar la consulta SQL para insertar un registro en la tabla 'certificados'
        $sql = "INSERT INTO certificados (id_usuario, fecha_concesion) VALUES (:idUsuario, :fechaConcesion)";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':idUsuario', $idUsuario);
        $stmt->bindParam(':fechaConcesion', $fechaConcesion);

        // Ejecutar la segunda consulta preparada
        if ($stmt->execute()) {
            echo "Usuario registrado exitosamente y certificado generado.";
        } else {
            echo "Error al generar el certificado: " . $stmt->errorInfo()[2]; // Obtener el mensaje de error
        }
    } else {
        echo "Error al registrar el usuario: " . $stmt->errorInfo()[2]; // Obtener el mensaje de error
    }
}

// Cerrar la conexión a la base de datos (no es necesario con PDO)
// $conexion->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Certificado</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--- CDN Bootstrap--->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!--- CSS--->
    <link rel="stylesheet" href="css/certi.css">
    <!--- Google Font--->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!--- Favicon --->
    <link rel="icon" type="image/x-icon" href="img/UTC_LOGO.png">
    <!--- SweetAlert2 --->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Portal Us</title>
</head>
<body>

<h2>Registro para certificado</h2>
<form method="post" action="generar_certificado.php">
<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
    <label for="nombreUsuario">Nombre completo:</label><br>
    <input type="text" id="nombreUsuario" name="nombreUsuario" required><br><br>
    <input type="submit" value="Registrarse">
</form>

</body>
</html>
