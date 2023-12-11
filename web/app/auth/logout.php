<?php

namespace App\Auth;

session_start();

session_destroy();

header("location: /index.php");
exit; // Asegúrate de salir después de la redirección