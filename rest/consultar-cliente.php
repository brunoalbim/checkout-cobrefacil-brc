<?php
require_once('../app/@config.php');
require_once('../modulos/cobrefacil.php');
$cobrefacil = new Cobrefacil;

if ($_POST['documento']) {

  $cliente = json_decode($cobrefacil->buscar_cliente_pelo_documento($_POST['documento'], json_decode($cobrefacil->authenticate($buscar_credenciais_cf), true), $buscar_credenciais_cf), true);

  if ($cliente['data'][0]) {
    echo $cliente['data'][0]['id'];
  } else {
    echo "nao";
  }

} else {
  echo "403 - Acesso não permitido.";
}
