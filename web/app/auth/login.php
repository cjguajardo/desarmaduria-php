<?php
session_start();
include_once(__DIR__ . "/../db.php");

if (isset($_POST['rut']) && isset($_POST['password'])) {
  $rut = $_POST['rut'];
  $password = $_POST['password'];

  $consulta = "SELECT * FROM usuario WHERE rut = '$rut' AND pswd = '$password'";
  $resul = mysqli_query($conn, $consulta);
  $filas = mysqli_num_rows($resul);

  if ($filas > 0) {
    while ($validarRol = mysqli_fetch_array($resul)) {
      $rol = $validarRol['FK_PERFIL'];
    }
    $_SESSION['rut'] = $rut;
    $_SESSION['rol'] = $rol;
  }
} else {
  // Si llega aquí, las credenciales son incorrectas
  $_SESSION['mensaje'] = 'Los datos ingresados no son válidos.';
}

header("location: /index.php");
exit; // Asegúrate de salir después de la redirección
