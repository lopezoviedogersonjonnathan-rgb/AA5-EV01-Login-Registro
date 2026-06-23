<?php
// ===========================================================
// ARCHIVO: registro.php
// QUÉ ES: formulario para crear una cuenta nueva, Y el código que
// procesa esos datos para guardarlos en la base de datos.
// Está todo en un solo archivo: la misma página se "auto-revisa"
// para saber si solo debe MOSTRAR el formulario o si debe
// PROCESAR datos que el usuario ya envió.
// ===========================================================
session_start();
require_once "db.php"; // importamos la conexión $conn creada en db.php

// Variable para mostrar mensajes de error o éxito en pantalla.
$mensaje = "";

// $_SERVER["REQUEST_METHOD"] le dice a PHP CÓMO llegó la petición
// a esta página: "GET" (solo entrar a verla) o "POST" (el usuario
// ya llenó el formulario y le dio clic a "Registrarse").
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Recuperamos los datos que el usuario escribió en el formulario.
    // $_POST es el arreglo que PHP llena con los campos enviados por POST.
    $nombre   = $_POST["nombre"];
    $email    = $_POST["email"];
    $password = $_POST["password"];

    // Antes de crear el usuario, revisamos si ya existe alguien
    // registrado con ese mismo correo (recuerda: email es UNIQUE).
    $sqlCheck = "SELECT id FROM usuarios WHERE email = ?";
    // El "?" es un "marcador" que luego se reemplaza de forma SEGURA
    // con bind_param. Esto evita un ataque llamado "inyección SQL".
    $stmtCheck = $conn->prepare($sqlCheck); // prepara la consulta
    $stmtCheck->bind_param("s", $email);    // "s" = el dato es un string (texto)
    $stmtCheck->execute();                  // ejecuta la consulta contra la base de datos
    $resultCheck = $stmtCheck->get_result(); // obtenemos el resultado

    if ($resultCheck->num_rows > 0) {
        // num_rows > 0 significa que ya encontramos una fila con ese correo.
        $mensaje = "Ese correo ya está registrado. Intenta iniciar sesión.";
    } else {

        // password_hash() NUNCA guarda la contraseña tal cual la escribió
        // el usuario. La convierte en un "hash": un texto largo e ilegible
        // que no se puede revertir para obtener la contraseña original.
        // PASSWORD_DEFAULT le dice a PHP "usa el algoritmo más seguro disponible".
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Consulta para INSERTAR (crear) el nuevo usuario en la tabla.
        $sql = "INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        // "sss" = los 3 valores que vamos a insertar son texto (string).
        $stmt->bind_param("sss", $nombre, $email, $passwordHash);

        if ($stmt->execute()) {
            // Si el INSERT funcionó, mandamos al usuario al login
            // con "?registrado=1" en la URL para mostrarle un mensaje de éxito allí.
            header("Location: index.php?registrado=1");
            exit(); // exit() detiene el script: nada después de un header(Location) debe ejecutarse.
        } else {
            $mensaje = "Ocurrió un error al registrar. Intenta de nuevo.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <style>
        /* Mismos estilos que index.php, para que las dos páginas se vean iguales. */
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 300px;
        }
        .login input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }
        .login button {
            width: 100%;
            padding: 8px;
            background: #16a34a; /* verde, para diferenciar de "Ingresar" (azul) */
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .mensaje {
            text-align: center;
            margin-bottom: 10px;
            font-size: 14px;
            color: #b91c1c;
        }
    </style>
</head>
<body>
    <div class="login">
        <h2>Crear Cuenta</h2>

        <?php if ($mensaje != ""): ?>
            <p class="mensaje"><?= $mensaje ?></p>
        <?php endif; ?>

        <!-- action="registro.php": el formulario se envía a SÍ MISMO.
             Por eso arriba comprobamos REQUEST_METHOD === "POST":
             así sabemos si solo se está mostrando la página o si
             ya llegaron datos para procesar. -->
        <form action="registro.php" method="POST">

            <!--
              Campo de nombre:
              - type="text"  -> campo de texto libre, sin validación especial.
              - name="nombre" -> en el PHP de arriba se lee como $_POST["nombre"].
            -->
            <input type="text" name="nombre" placeholder="Nombre completo" required>

            <!-- Campo de correo, igual que en index.php. -->
            <input type="email" name="email" placeholder="Correo" required>

            <!--
              Campo de contraseña:
              - minlength="6" -> el navegador exige mínimo 6 caracteres
                                  ANTES de poder enviar el formulario.
            -->
            <input type="password" name="password" placeholder="Contraseña" minlength="6" required>

            <button type="submit">Registrarse</button>
        </form>

        <p style="text-align:center; margin-top:10px; font-size:14px;">
            ¿Ya tienes cuenta?
            <a href="index.php">Inicia sesión</a>
        </p>
    </div>
</body>
</html>
