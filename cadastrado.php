<?php
  require_once('app/@config.php');
  require_once('header.php');
?>

<div class="uk-container uk-container-xsmall uk-margin-top uk-margin-bottom">
  <center>
    <div>
      <div class="wrapper-check">
        <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52"> <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/> <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/></svg>
      </div>
      <h2> <strong>Confirmado</strong> </h2>
      <p> Você já tem cadastrado com o documento <?= $_GET['documento'] ?> <br> Obrigado pela confirmação. </p>
      <p>
        ID# <?= $_GET['id_cliente_cf'] ?>
      </p>
    </div>
  </center>
</div>

<?php require_once('footer.php'); ?>
