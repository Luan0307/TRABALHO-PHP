<?php

require_once 'helpers.php';
sessionStart();

if (!empty($_SESSION['usuario_id'])) {
    redirect('dashboard.php');
}

redirect('loja.php');
