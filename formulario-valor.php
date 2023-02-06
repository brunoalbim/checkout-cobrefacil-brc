<?php
require_once('app/@config.php');
require_once('modulos/cobrefacil.php');
$cobrefacil = new Cobrefacil;
$cobrefacil_authenticate = json_decode($cobrefacil->authenticate($buscar_credenciais_cf), true);

if($_SESSION['ref'] === "planoid") {
  $handle = fopen("app/mensalidades.csv", "r");
  $row = 0;
  while ($line = fgetcsv($handle, 1000, ",")) {
  	if ($row++ == 0) {
  		continue;
  	}

    if ($line[0] === $_SESSION['desc']) {
      $plano[] = [
    		'id' => $line[0],
    		'plano_id' => $line[1],
    		'intervalo_cobranca' => $line[2],
    		'meios_de_pagamento' => $line[3]
    	];
    }

  }
  fclose($handle);

  $buscar_plano_ou_servico = 'buscar_'.$plano_ou_servico;
  $infoPlanoId = json_decode($cobrefacil->{$buscar_plano_ou_servico}($plano[0]['plano_id'], $cobrefacil_authenticate, $buscar_credenciais_cf), true);
}

$_SESSION['mensalidadecsv'] = $plano[0];
$_SESSION['v'] = $infoPlanoId['data']['price'];

?>

<center>
  <?php logo_site() ?>
  <h1 class="uk-margin-small-bottom"> <strong>Gerar fatura</strong> </h1>
  <p class="uk-margin-remove-top">Confirme o valor do pagamento a ser realizado.</p>
</center>


<form id="gerar_boleto" action="<?= base_url('gerar-boleto') ?>" method="get">
  <input type="hidden" name="referencia" value="<?= $_SESSION['ref']?: "" ?>">
  <input type="hidden" name="id_cliente_cf" value="<?= $_SESSION['id_cliente_cf']?: "" ?>">
  <p>
    <label>
      Valor (R$) <em>*</em>
      <input type="tel" class="uk-input money <?= $_SESSION['v'] ? 'desativado':'' ?>" name="valor" <?= $_SESSION['v'] ? 'readonly':'' ?> placeholder="0,00" value="<?= $_SESSION['v']?: "" ?>">
    </label>
  </p>
  <?php if($_SESSION['ref'] === "planoid") { ?>
    <input type="hidden" name="opcao_de_pagamento" value="gerar_mensalidade">
  <?php } else { ?>
    <p>
      <label>
        Opção de pagamento <em>*</em>
        <select class="uk-select" name="opcao_de_pagamento">
          <option value="gerar_boleto">Pagar no Boleto</option>
          <option value="gerar_pix">Pagar no PIX</option>
          <!--<option value="gerar_cartao">Pagar no Cartão 1x <?= $jurosCartao && $jurosCartao > 0 ? '(+'.$jurosCartao.'% juros)':'' ?></option>-->
        </select>
      </label>
    </p>
  <?php } ?>
  <?php if($_SESSION['ref'] === "planoid") { ?>
    <p>
      <label>
        Descrição
        <input class="uk-input desativado" readonly value="<?= $infoPlanoId['data']['name'] ?: $infoPlanoId['data']['description'] ?>">
      </label>
    </p>
  <?php } else { ?>
    <p>
      <label>
        Descrição
        <input name="descricao" class="uk-input <?= $_SESSION['desc'] ? 'desativado':'' ?>" <?= $_SESSION['desc'] ? 'readonly':'' ?> placeholder="opcional" value="<?= $_SESSION['desc']?: "" ?>">
      </label>
    </p>
  <?php } ?>

  <p>
    <button style="width: 100%" type="submit" class="uk-button uk-button-primary">
      <?php if($_SESSION['ref'] === "planoid") { ?>
        Criar assinatura <span uk-icon="arrow-right"></span>
      <?php } else { ?>
        Criar pagamento <span uk-icon="arrow-right"></span>
      <?php } ?>
    </button>
  </p>
</form>

<center>
  <p> <a href="#" class="limpar-sessao uk-button uk-button-default">Limpar sessão</a> </p>
  <p class="uk-text-muted uk-margin-remove"> <small><?= $_SESSION['id_cliente_cf'] ?> / <?= $buscar_credenciais_cf['ambiente'] ?></small> </p>
</center>
