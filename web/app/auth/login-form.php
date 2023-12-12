<div class="container-sm p-5 border border-dark rounded bg-light w-50 text-center mt-5">
  <h1>Iniciar Sesión</h1>

  <form action="/app/auth/login.php" method="post">
    <div class="mb-3">
      <label for="rut" class="form-label">Rut</label>
      <input type="text" class="form-control" id="rut" placeholder="Ingrese su rut" name="rut" required>
    </div>

    <div class="mb-3">
      <label for="pwd" class="form-label">Contraseña</label>
      <input type="password" class="form-control" id="pwd" placeholder="Ingrese su contraseña" name="password" required>
    </div>

    <button type="submit" class="btn btn-success">Aceptar</button>
  </form>
</div>