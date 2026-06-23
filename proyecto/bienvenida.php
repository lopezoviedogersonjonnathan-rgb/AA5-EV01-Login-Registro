<?php
// ===========================================================
// ARCHIVO: bienvenida.php
// QUÉ ES: la página que ve el usuario DESPUÉS de iniciar sesión
// correctamente. Es una página "protegida": si alguien intenta
// entrar aquí directamente sin haber hecho login, lo regresamos
// al formulario de inicio de sesión.
// ===========================================================
session_start();

// isset() comprueba si esa "llave" existe dentro de $_SESSION.
// Si NO existe "usuario_id", significa que esta persona nunca
// inició sesión (o cerró sesión), así que no puede ver esta página.
if (!isset($_SESSION["usuario_id"])) {
    header("Location: index.php"); // lo mandamos de vuelta al login
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenida</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .card {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 320px;
            text-align: center;
        }
        .ok {
            color: #16a34a; /* verde de éxito */
            font-weight: bold;
        }
        a.salir {
            display: inline-block;
            margin-top: 15px;
            color: #b91c1c;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="card">
        <!-- Mensaje EXACTO que pide el ejercicio cuando la autenticación es correcta. -->
        <p class="ok">Autenticación satisfactoria</p>

        <h2>
            <!--
              La sintaxis corta de PHP para imprimir un valor (la que empieza
              con "menor que, signo igual" y cierra con "signo de interrogación,
              mayor que") muestra aquí el valor de una variable PHP.
              $_SESSION["usuario_nombre"] lo guardamos en login.php justo
              cuando la contraseña fue verificada con éxito.
            -->
            Bienvenido, <?= $_SESSION["usuario_nombre"] ?>
        </h2>

        <!-- href="logout.php": enlace para cerrar sesión. -->
        <a class="salir" href="logout.php">Cerrar sesión</a>
    </div>
</body>
</html>
