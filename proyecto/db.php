<?php
// ===========================================================
// ARCHIVO: db.php
// PARA QUÉ SIRVE: este archivo solo hace UNA cosa: conectar
// nuestro código PHP con la base de datos MySQL.
// Lo dejamos en un archivo separado para no repetir este mismo
// código en cada página (login.php, registro.php, etc). Esas
// páginas simplemente lo "importan" con require_once "db.php";
// ===========================================================

// Nombre del servidor donde vive la base de datos.
// Como trabajamos en nuestro propio computador con XAMPP,
// el servidor siempre se llama "localhost" (= "este mismo equipo").
$host = "localhost";

// Usuario de la base de datos. XAMPP trae por defecto el usuario
// "root" (el administrador de MySQL) sin contraseña.
$usuario_db = "root";

// Contraseña del usuario de la base de datos.
// La dejamos vacía "" porque así viene XAMPP de fábrica.
// (Si tú le pusiste contraseña a tu MySQL, escríbela aquí).
$password_db = "";

// Nombre de la base de datos que vamos a usar.
// Debe ser IGUAL al que ves en phpMyAdmin y al que crea basedatos.sql.
$nombre_db = "login_db";

// Puerto donde está escuchando tu MySQL de XAMPP.
// Lo normal es el 3306, PERO en este computador el 3306 ya está
// ocupado por otro programa, así que XAMPP quedó configurado para
// usar el 3307 (lo confirmamos mirando phpMyAdmin: dice "Servidor: 127.0.0.1:3307").
// Si en tu caso es distinto, cambia este número por el que te
// aparezca al lado de "MySQL" en el Panel de Control de XAMPP.
$puerto_db = 3307;

// "mysqli" es una clase que ya trae PHP para hablar con MySQL.
// Aquí creamos un OBJETO llamado $conn ("conexión"), pasándole
// host, usuario, contraseña, nombre de la base de datos y PUERTO,
// en ese orden exacto.
$conn = new mysqli($host, $usuario_db, $password_db, $nombre_db, $puerto_db);

// $conn->connect_error nos dice si algo falló al conectar
// (por ejemplo: Apache o MySQL apagados en el panel de XAMPP,
// o el nombre de la base de datos mal escrito).
if ($conn->connect_error) {
    // die() detiene el script inmediatamente y muestra el error en pantalla.
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

// Si llegamos hasta aquí sin errores, la variable $conn queda lista
// para que cualquier archivo que haga require_once "db.php" la use.
?>
