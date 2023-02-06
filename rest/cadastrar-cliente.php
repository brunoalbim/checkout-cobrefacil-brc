<?php
require_once('../app/@config.php');
require_once('../modulos/cobrefacil.php');
$cobrefacil = new Cobrefacil;

if ($_POST) {

  $cliente = json_decode($cobrefacil->cadastrar_cliente($_POST, json_decode($cobrefacil->authenticate($buscar_credenciais_cf), true), $buscar_credenciais_cf), true);

  if ($cliente['errors']) {
    echo json_encode([
      "retorno" => "erro",
      "mensagem" => $cliente['errors'][0]
    ]);
  } else {
    echo json_encode([
      "retorno" => "sucesso",
      "dados" => $cliente['data']['id']
    ]);
  }

} else {
  echo "403 - Acesso não permitido.";
}
