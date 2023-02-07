<?php
  require_once('app/@config.php');
  require_once('modulos/cobrefacil.php');
  $cobrefacil = new Cobrefacil;
  $cobrefacil_authenticate = json_decode($cobrefacil->authenticate($buscar_credenciais_cf), true);

  $dados_fatura = $cobrefacil->buscar_fatura($_GET['id_fatura'], $cobrefacil_authenticate, $buscar_credenciais_cf);
  $dados_fatura = json_decode($dados_fatura, true);

  require_once('header.php');
?>

<div class="uk-container uk-container-xsmall">
  <center>
    <div class="wrapper-check">
      <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52"> <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/> <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/></svg>
    </div>
    <h1> <strong>Fatura gerada!</strong> </h1>
    <p> Sua fatura no valor de R$<?= $dados_fatura['data']['price'] ?>, foi gerado e esta disponivel para pagamento. <br> Você tambem irá receber um e-mail nosso. </p>
    <?php if($_GET['op'] === "gerar_boleto") { ?>
      <p> <a style="width: 100%" class="uk-button uk-button-primary" target="_blank" href="<?= $dados_fatura['data']['url'] ?>/boleto-impressao"> Abrir boleto </a> </p>
    <?php } else { ?>
      <p> <a style="width: 100%" class="uk-button uk-button-primary" target="_blank" href="<?= $dados_fatura['data']['url'] ?>"> Pagar agora! </a> </p>
    <?php } ?>

    <p>Cobrança ID: <?= $dados_fatura['data']['id'] ?></p>
  </center>
</div>

<?php require_once('footer.php'); ?>
