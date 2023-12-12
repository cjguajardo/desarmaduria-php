<?php

namespace App\Auth;

require_once __DIR__ . '/../helpers/layout.php';

use App\Helpers\LayoutHelper as LayoutHelper;

$layout = new LayoutHelper();

$content = file_get_contents(__DIR__ . '/login-form.php');
$layout->render('Iniciar Sesión', $content);
