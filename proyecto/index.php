<?php
// ===========================================================
// ARCHIVO: index.php
// QUÉ ES: la "puerta de entrada" del sistema → el formulario de LOGIN.
// session_start() SIEMPRE debe ser la primera línea de PHP en una
// página que use sesiones, porque activa el mecanismo que permite
// al servidor "recordar" quién eres mientras navegas entre páginas.
// ===========================================================
session_start();

// Variable donde guardaremos el mensaje que se le mostrará al usuario
// (de error o de éxito). Empieza vacía.
$mensaje = "";

// $_GET es un arreglo que PHP llena solo con los datos que vienen
// escritos en la URL después del símbolo "?".
// Ejemplo: index.php?error=1  ->  $_GET["error"] vale "1".

// Si login.php nos trajo de vuelta aquí con "?error=1", es porque
// el correo o la contraseña que escribió el usuario eran incorrectos.
if (isset($_GET["error"])) {
    $mensaje = "Error en la autenticación: correo o contraseña incorrectos.";
}

// Si registro.php nos trajo aquí con "?registrado=1", es porque el
// usuario se registró con éxito y ya puede iniciar sesión.
if (isset($_GET["registrado"])) {
    $mensaje = "Registro exitoso. Ahora puedes iniciar sesión.";
}
?>
<!DOCTYPE html>
<!-- <!DOCTYPE html>: le dice al navegador "este documento usa HTML5"
     (la versión moderna de HTML). Siempre va en la primera línea. -->
<html lang="es">
<!-- <html>: etiqueta que envuelve TODO el documento.
     lang="es": le avisa al navegador (y a lectores de pantalla)
     que el contenido está escrito en español. -->

<head>
<!-- <head>: contiene información que el navegador necesita pero que
     NO se dibuja en la pantalla (título, charset, estilos, etc). -->

    <meta charset="UTF-8">
    <!-- meta charset="UTF-8": le dice al navegador qué "alfabeto" de
         caracteres usar. Con UTF-8 las tildes, la ñ, etc. se ven bien. -->

    <title>Login</title>
    <!-- <title>: el texto que aparece en la pestaña del navegador. -->

    <style>
    /* Todo lo de aquí adentro es CSS: el lenguaje que define
       cómo se VE la página (colores, tamaños, posiciones). */

        body {
            /* "body" selecciona TODA la página. */
            font-family: Arial, sans-serif; /* tipo de letra a usar */
            background: #f4f4f4;            /* color de fondo gris claro */
            display: flex;                  /* activa "cajas flexibles" para acomodar el contenido */
            justify-content: center;        /* centra el contenido de forma horizontal */
            align-items: center;            /* centra el contenido de forma vertical */
            height: 100vh;                  /* ocupa el 100% del alto de la pantalla */
            margin: 0;                      /* quita el margen blanco que el navegador pone por defecto */
        }

        .login {
            /* el punto "." indica que esto es una CLASE de CSS.
               la usamos en el HTML escribiendo class="login" */
            background: white;
            padding: 30px;                       /* espacio interno */
            border-radius: 8px;                   /* esquinas redondeadas */
            box-shadow: 0 0 10px rgba(0,0,0,0.1); /* sombra suave alrededor de la caja */
            width: 300px;
        }

        .login input {
            /* selecciona todos los <input> que estén DENTRO de .login */
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box; /* el padding no aumenta el ancho total del input */
        }

        .login button {
            width: 100%;
            padding: 8px;
            background: #2563eb; /* azul */
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer; /* el cursor se convierte en "manito" al pasar encima */
        }

        .mensaje {
            text-align: center;
            margin-bottom: 10px;
            font-size: 14px;
            color: #b91c1c; /* rojo, para que el mensaje de error/éxito resalte */
        }
    </style>
</head>

<body>
<!-- <body>: contiene TODO lo que sí se dibuja en la pantalla. -->

    <div class="login">
    <!-- <div>: simple "caja" contenedora sin significado propio,
         la usamos solo para poder aplicarle estilo con CSS.
         class="login": le asigna la clase que definimos arriba. -->

        <h2>Iniciar Sesión</h2>
        <!-- <h2>: encabezado / título de nivel 2. -->

        <?php if ($mensaje != ""): ?>
            <!-- Esto es PHP "incrustado" dentro del HTML: si la variable
                 $mensaje tiene contenido, se muestra el párrafo. -->
            <p class="mensaje"><?= $mensaje ?></p>
            <!-- La línea de arriba usa la forma corta de PHP para imprimir
                 (equivale a escribir php echo $mensaje; entre etiquetas php).
                 "echo" significa "imprime esto en la pantalla". -->
        <?php endif; ?>

        <form action="login.php" method="POST">
        <!-- <form>: agrupa los campos que el usuario va a llenar.
             action="login.php": al enviar el formulario, los datos viajan a login.php.
             method="POST": los datos se envían "ocultos" en el cuerpo de la
             petición (a diferencia de "GET", que los pondría visibles en la URL). -->

            <!--
              Campo de correo:
              - type="email"   -> el navegador valida que el texto tenga forma de correo.
              - name="email"   -> el "nombre" con el que el dato llega a login.php
                                   (allí se recupera como $_POST["email"]).
              - placeholder    -> texto gris de ayuda, visible solo cuando el campo está vacío.
              - required       -> el navegador no deja enviar el formulario si está vacío.
            -->
            <input type="email" name="email" placeholder="Correo" required>

            <!--
              Campo de contraseña:
              - type="password" -> cada letra escrita se muestra como • • • en pantalla.
              - name="password"  -> en login.php se recupera como $_POST["password"].
              - required         -> campo obligatorio.
            -->
            <input type="password" name="password" placeholder="Contraseña" required>

            <!-- <button type="submit">: al hacer clic, envía el formulario
                 hacia la URL indicada en "action". -->
            <button type="submit">Ingresar</button>
        </form>

        <p style="text-align:center; margin-top:10px; font-size:14px;">
        <!-- style="...": aplica CSS directamente sobre ESTA etiqueta únicamente. -->
            ¿No tienes cuenta?
            <a href="registro.php">Regístrate aquí</a>
            <!-- <a href="registro.php">: enlace que lleva a la página de registro. -->
        </p>
    </div>
</body>
</html>
