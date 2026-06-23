<?php
// ===========================================================
// ARCHIVO: login.php
// QUÉ ES: este archivo NO tiene HTML, es puro PHP. Su único trabajo
// es recibir los datos del formulario de index.php, comprobar si
// el correo y la contraseña son correctos, y decidir a dónde
// mandar al usuario después (bienvenida.php o de vuelta al login
// con un mensaje de error).
// ===========================================================
session_start();           // activamos el sistema de sesiones
require_once "db.php";     // importamos la conexión $conn

// Recuperamos los datos que el usuario escribió en index.php.
// $_POST["email"] coincide con name="email" del <input> del formulario.
$email    = $_POST["email"];
$password = $_POST["password"];

// Buscamos en la tabla "usuarios" si existe una fila con ese correo.
$sql = "SELECT * FROM usuarios WHERE email = ?";
// "?" es un marcador que se rellena de forma segura más abajo,
// esto evita ataques de "inyección SQL".
$stmt = $conn->prepare($sql);     // prepara la consulta
$stmt->bind_param("s", $email);   // "s" = el valor es un string (texto)
$stmt->execute();                 // ejecuta la consulta
$result = $stmt->get_result();    // guarda el resultado obtenido

// num_rows === 1 significa "encontramos EXACTAMENTE un usuario con ese correo".
if ($result->num_rows === 1) {

    // fetch_assoc() convierte la fila encontrada en un arreglo asociativo,
    // por ejemplo: $usuario["nombre"], $usuario["email"], $usuario["password"]...
    $usuario = $result->fetch_assoc();

    // password_verify() compara la contraseña que el usuario escribió
    // ($password, en texto normal) contra el HASH guardado en la base
    // de datos ($usuario["password"]). Internamente vuelve a encriptar
    // $password con el mismo método y compara los resultados.
    if (password_verify($password, $usuario["password"])) {

        // ¡Contraseña correcta! Autenticación satisfactoria.
        // Guardamos datos en la SESIÓN para "recordar" que este
        // usuario ya inició sesión en las próximas páginas.
        $_SESSION["usuario_id"]     = $usuario["id"];
        $_SESSION["usuario_nombre"] = $usuario["nombre"];

        // header("Location: ...") manda al navegador a otra página.
        header("Location: bienvenida.php");
        exit(); // siempre se debe cortar la ejecución después de un Location.

    } else {
        // El correo existe, pero la contraseña no coincide.
        header("Location: index.php?error=1");
        exit();
    }

} else {
    // No existe ningún usuario con ese correo.
    header("Location: index.php?error=1");
    exit();
}
?>
