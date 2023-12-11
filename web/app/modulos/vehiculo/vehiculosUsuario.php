<!DOCTYPE html>
<html lang="en">

<head>
  <title>Desarmaduria</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="../css/main.min.css" rel="stylesheet">
  <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.js"></script>
</head>

<body class="d-flex flex-column min-vh-100 bg-primary">
  <header>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
      <div class="container-fluid">
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <a href="repuestosUsuario.php" class="nav-link">Repuestos</a>
          </li>
          <li class="nav-item">
            <a href="accesoriosUsuario.php" class="nav-link">Accesorios</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">Vehículos</a>
          </li>
        </ul>
        <form class="d-flex">
          <a href="login.php" class="btn btn-primary">Ingresar</a>
        </form>
      </div>
    </nav>
  </header>

  <div class="container flex-grow-1">
    <!-- Contenido principal aquí -->
    <?php
    include 'mostrarVehiculos.php';
    
    ?>
    
  </div>

  <footer class="bg-dark text-white">
    <div class="container-fluid p-4">
      <!-- Contenido del footer aquí -->
      <div class="text-center">
        <p class="mb-0"></p>
      </div>
    </div>
  </footer>

  <!-- Bootstrap JavaScript Libraries -->
</body>

</html>
