<?php

require_once __DIR__ . '/../helpers/links.php';
require_once __DIR__ . '/../helpers/autenticado.php';

use App\Helpers\Links as Links;
use App\Helpers\Autenticado as Autenticado;

$rol = Autenticado::rol() ?? 0;

$links = new Links();
$links = $links->getLinks($rol);

?>

<h1 class="text-light">Bienvenid@</h1>
<hr class="text-light">

<div class="row justify-content-center">
  <?php foreach ($links as $link) : ?>
    <a href="<?= $link['href'] ?>" class="col-12 col-md-4 my-3">
      <div class="btn btn-light text-dark w-100">
        <?= $link['title'] ?>
      </div>
    </a>
  <?php endforeach; ?>
</div>