<?php
// ===========================================================
// ARCHIVO: logout.php
// QUÉ ES: cierra la sesión activa del usuario y lo regresa al login.
// ===========================================================
session_start();      // necesitamos "entrar" a la sesión para poder destruirla
session_destroy();    // borra TODOS los datos guardados en $_SESSION
header("Location: index.php"); // regresa al usuario al formulario de login
exit();
?>
