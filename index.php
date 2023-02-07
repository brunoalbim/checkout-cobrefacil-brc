<?php
  session_start();
  require_once('app/@config.php');
  require_once('header.php');
?>



<?php
  if ($_GET['ref']) {
    $_SESSION['ref'] = $_GET['ref'];
  } else {
    if (!$_SESSION['ref']) {
      $_SESSION['ref'] = "";
    }
  }

  if ($_GET['desc']) {
    $_SESSION['desc'] = $_GET['desc'];
  } else {
    if (!$_SESSION['desc']) {
      $_SESSION['desc'] = "";
    }
  }

  if ($_GET['v']) {
    $_SESSION['v'] = $_GET['v'];
  } else {
    if (!$_SESSION['v']) {
      $_SESSION['v'] = "";
    }
  }

  if ($_GET['id_cliente_cf']) {
    $_SESSION['id_cliente_cf'] = $_GET['id_cliente_cf'];
  }
?>


<div class="container-principal uk-container uk-container-xsmall uk-margin-top uk-margin-bottom">
  <?php
    if ($_SESSION['id_cliente_cf']) {
      require_once('formulario-valor.php');
    } else {
      require_once('formulario-cliente.php');
    }
  ?>
  <center>
    <?php if($_SESSION['ref']) { ?>
      <p class="uk-text-muted uk-margin-remove"> <small>Ref.: <?= $_SESSION['ref'] ?></small> </p>
    <?php } ?>
    <p class="uk-text-muted uk-margin-remove"> <small>Certificado SSL/TLS. Seus dados estão seguros. <br> BRCXP © <?= date('Y') ?> (v<?= json_decode(file_get_contents('versao.json'), true)['versao'] ?>)</small> </p>
  </center>
</div>


<?php require_once('footer.php'); ?>
