# GA7-220501096-AA5-EV01 — Servicio web de Registro e Inicio de Sesión

## 1. ¿Qué lenguajes y herramientas se usan aquí?

No es un solo lenguaje, son varios trabajando juntos. Cada uno hace una parte distinta:

| Herramienta | Para qué sirve |
|---|---|
| **HTML** | Estructura de la página (formularios, botones, texto). No es un "lenguaje de programación" como tal, es de marcado. |
| **CSS** | El "maquillaje" visual: colores, tamaños, centrado de la caja blanca. |
| **PHP** | El lenguaje de **servidor**. Es el que realmente piensa: recibe lo que el usuario escribió, habla con la base de datos, decide si la contraseña es correcta, etc. Todo lo que ves entre `<?php ... ?>` es PHP. |
| **MySQL** | El motor de base de datos donde se guardan los usuarios (nombre, correo, contraseña encriptada). |
| **XAMPP** | Un programa que instala TODO lo anterior (Apache, PHP, MySQL) en tu computador de una sola vez, para que puedas probar esto sin internet. |
| **phpMyAdmin** | La página web (incluida en XAMPP) para ver/crear tablas de MySQL con clics, sin escribir comandos. |
| **Git / GitHub** | El sistema de versionamiento que pide la evidencia: guarda el historial de cambios de tu código y lo sube a un repositorio en línea. |

## 2. Estructura del proyecto

```
proyecto/
├── db.php          -> conexión a la base de datos
├── basedatos.sql   -> script para crear la base de datos y la tabla en phpMyAdmin
├── index.php       -> formulario de inicio de sesión (login)
├── login.php       -> procesa el login (verifica usuario y contraseña)
├── registro.php    -> formulario + procesamiento del registro de usuarios nuevos
├── bienvenida.php  -> página que se ve tras un login correcto ("Autenticación satisfactoria")
└── logout.php      -> cierra la sesión
```

Cada archivo tiene **comentarios línea por línea** explicando qué hace cada etiqueta, atributo o instrucción. Ábrelos en VS Code y lee los comentarios (empiezan con `//`, `/* */` en PHP/CSS o `<!-- -->` en HTML).

## 3. Cómo ejecutarlo en tu computador

1. Copia la carpeta `proyecto` dentro de `C:\xampp\htdocs\` y, si quieres, renómbrala (ej: `htdocs\AA5_EV01\`).
2. Abre el **Panel de Control de XAMPP** y dale **Start** a `Apache` y a `MySQL`.
3. Abre el navegador en `http://localhost/phpmyadmin`.
4. Ve a la pestaña **SQL**, pega el contenido de `basedatos.sql` y dale **Continuar/Go**. Esto crea la base de datos `login_db` y la tabla `usuarios`.
5. Abre `http://localhost/AA5_EV01/` (o el nombre que le pusiste a la carpeta).
6. Haz clic en "Regístrate aquí", crea un usuario de prueba.
7. Inicia sesión con ese usuario:
   - Si los datos son correctos → verás **"Autenticación satisfactoria"**.
   - Si el correo o la contraseña están mal → verás **"Error en la autenticación"**.

## 4. Cómo subirlo a un repositorio con Git Bash

Abre **Git Bash** dentro de la carpeta del proyecto (clic derecho sobre la carpeta → "Git Bash Here") y ejecuta, uno por uno:

```bash
# 1. Convierte esta carpeta en un repositorio de Git (solo se hace una vez)
git init

# 2. Configura tu nombre y correo (solo la primera vez que usas Git en tu PC)
git config --global user.name "Tu Nombre"
git config --global user.email "tu_correo@gmail.com"

# 3. Agrega todos los archivos al "área de preparación" (staging)
git add .

# 4. Crea el primer "commit" (una foto/guardado del estado actual del código)
git commit -m "Primer commit: login y registro con PHP y MySQL"
```

Ahora ve a [github.com](https://github.com), inicia sesión, haz clic en **New repository**, ponle un nombre (ej: `AA5-EV01-login`) y créalo **vacío** (sin README, sin .gitignore). GitHub te mostrará una URL parecida a:
`https://github.com/tu-usuario/AA5-EV01-login.git`

Cópiala y sigue en Git Bash:

```bash
# 5. Conecta tu repositorio local con el repositorio remoto de GitHub
git remote add origin https://github.com/tu-usuario/AA5-EV01-login.git

# 6. Renombra tu rama principal a "main" (estándar actual de GitHub)
git branch -M main

# 7. Sube (push) tus archivos al repositorio remoto
git push -u origin main
```

Si te pide usuario y contraseña: GitHub ya no acepta tu contraseña normal desde la terminal, te pedirá un **Personal Access Token**. Lo generas en GitHub: *Settings → Developer settings → Personal access tokens → Generate new token (classic)*, marca el permiso `repo`, cópialo y pégalo como si fuera la contraseña cuando Git Bash te lo pida.

Cada vez que hagas un cambio nuevo en el código, repite solo estos tres pasos:

```bash
git add .
git commit -m "Descripción corta de lo que cambiaste"
git push
```

Cuando termines, copia la URL de tu repositorio (la misma que usaste en `git remote add origin`) y pégala dentro del archivo `enlace_repositorio.txt` que viene en esta misma carpeta.

## 5. Notas sobre los pantallazos del profesor

En las capturas que compartiste se ven algunos detalles que aquí ya quedaron corregidos:
- `$stmt->bind_param("s", $email);` necesita la letra del tipo de dato (`"s"` de string) **antes** de la variable — en este proyecto ya está bien escrito en `login.php` y `registro.php`.
- El bloque `if (... ) { ... } else { ... }` debe tener un espacio entre `}` y `else` (`} else {`), si no, PHP puede marcar error de sintaxis.
- `password_hash()` solo debe usarse cuando se **crea** un usuario (registro); para **comprobar** el login siempre se usa `password_verify()`, nunca se compara la contraseña en texto plano contra el hash.
- Falta el `exit();` después de cada `header("Location: ...")`. Sin él, el script puede seguir ejecutando código después de redirigir, lo que a veces genera comportamientos raros. En este proyecto cada redirección lleva su `exit();`.
