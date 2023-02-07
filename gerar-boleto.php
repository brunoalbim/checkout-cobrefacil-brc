<?php
  session_start();
  require_once('app/@config.php');
  require_once('modulos/cobrefacil.php');
  $cobrefacil = new Cobrefacil;
  $cobrefacil_authenticate = json_decode($cobrefacil->authenticate($buscar_credenciais_cf), true);

  $valor = $_GET['valor'];
  $opcao_de_pagamento = $_GET['opcao_de_pagamento'];

  if (!$valor) {
    header("Location: ".base_url());
  }

  if ($opcao_de_pagamento === "gerar_cartao" && $jurosCartao > 0) {
    $valor = str_replace(",", ".", str_replace(".", "", $valor));
    $valor = number_format((($valor * $jurosCartao) / 100) + $valor, 2, '', '');
  }

  $informacoes_post = [
     "ref" => $_GET['referencia'] ?: "",
     "id_cliente_cf" => $_GET['id_cliente_cf'] ?: "",
     "descricao" => $_GET['descricao'] ?: "",
     "valor" => str_replace([',','.'], '', $valor),
   ];

   if ($opcao_de_pagamento === 'gerar_mensalidade') {
     $informacoes_post['plano_ou_servico'] = $plano_ou_servico;
     $informacoes_post['plano_id'] = $_SESSION['mensalidadecsv']['plano_id'];
     $informacoes_post['intervalo_cobranca'] = $_SESSION['mensalidadecsv']['intervalo_cobranca'];
     $informacoes_post['meios_de_pagamento'] = $_SESSION['mensalidadecsv']['meios_de_pagamento'];
   }

  $function_pagamento = $cobrefacil->$opcao_de_pagamento($informacoes_post, $cobrefacil_authenticate, $buscar_credenciais_cf);

  $cobrefacil_resultado = json_decode($function_pagamento, true);

  if ($opcao_de_pagamento === 'gerar_mensalidade') {
    $gerar_cobranca_mensalidade = json_decode($cobrefacil->gerar_cobranca_mensalidade($cobrefacil_resultado['data']['id'], $cobrefacil_authenticate, $buscar_credenciais_cf), true);
    $id_fatura = $gerar_cobranca_mensalidade['data']['id'];
  } else {
    $id_fatura = $cobrefacil_resultado['data']['id'];
  }

  session_destroy();

  header("Location: ".base_url().'sucesso/?id_fatura='.$id_fatura.'&op='.$opcao_de_pagamento);
