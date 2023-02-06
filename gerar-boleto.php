<?php
  session_start();
  require_once('app/@config.php');
  require_once('modulos/cobrefacil.php');

  $valor = $_GET['valor'];
  $opcao_de_pagamento = $_GET['opcao_de_pagamento'];

  if (!$valor) {
    header("Location: ".base_url());
  }

  if ($opcao_de_pagamento === "gerar_cartao" && $jurosCartao > 0) {
    $valor = str_replace(",", ".", str_replace(".", "", $valor));
    $valor = number_format((($valor * $jurosCartao) / 100) + $valor, 2, '', '');
  }


  if (str_replace([',','.'], '', $valor) === str_replace([',','.'], '', $_SESSION['valor'])) {
    $fonte = "SESSION";
  } else {
    $fonte = "API";
    $cobrefacil = new Cobrefacil;
    $cobrefacil_authenticate = json_decode($cobrefacil->authenticate($buscar_credenciais_cf), true);

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

      $_SESSION['valor'] = $gerar_cobranca_mensalidade['data']['price'];
      $_SESSION['url'] = $gerar_cobranca_mensalidade['data']['url_invoice'];
      $_SESSION['id'] = $gerar_cobranca_mensalidade['data']['id'];
      $_SESSION['due_date'] = date("d/m/Y", strtotime($gerar_cobranca_mensalidade['data']['due_date']));
    } else {
      $_SESSION['valor'] = $cobrefacil_resultado['data']['price'];
      $_SESSION['url'] = $cobrefacil_resultado['data']['url'];
      $_SESSION['id'] = $cobrefacil_resultado['data']['id'];
      $_SESSION['due_date'] = date("d/m/Y", strtotime($cobrefacil_resultado['data']['due_date']));
    }

  }

  require_once('header.php');
?>

<div class="uk-container uk-container-xsmall">
  <center>
    <div class="wrapper-check">
      <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52"> <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/> <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/></svg>
    </div>
    <h1> <strong>Fatura gerada!</strong> </h1>
    <p> Sua fatura no valor de R$<?= $_SESSION['valor'] ?>, foi gerado e esta disponivel para pagamento. <br> Você tambem irá receber um e-mail nosso. </p>
    <?php if($opcao_de_pagamento === "gerar_boleto") { ?>
      <p> <a style="width: 100%" class="uk-button uk-button-primary" target="_blank" href="<?= $_SESSION['url'] ?>/boleto-impressao"> Abrir boleto </a> </p>
    <?php } else { ?>
      <p> <a style="width: 100%" class="uk-button uk-button-primary" target="_blank" href="<?= $_SESSION['url'] ?>"> Pagar agora! </a> </p>
    <?php } ?>

    <p>Cobrança ID: <?= $_SESSION['id'] ?></p>
    <p class="uk-text-muted uk-margin-top"> <small>GET: <?= $fonte ?></small> </p>
  </center>
</div>

<?php require_once('footer.php'); ?>
