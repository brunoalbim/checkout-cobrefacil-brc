<?php
  require_once('app/@config.php');
  require_once('header.php');
?>

<div class="container-principal uk-container uk-container-xsmall uk-margin-top uk-margin-bottom">
  <div>
    <center>
      <?php logo_site() ?>
      <h1 class="uk-margin-small-bottom"> <strong>Criar mensalidade</strong> </h1>
      <p class="uk-margin-small-top"> Preencha os campos abaixo. </p>
    </center>

    <form>
      <p>
        <label>
          ID do plano
          <input type="text" class="uk-input" name="plano_id" value="" required>
        </label>
      </p>
      <p>
        <label>
          Intervalo das cobranças (mês)
          <input type="number" class="uk-input" name="intervalo_cobranca" value="" required>
          <small>Valores de 1 a 12. Ex: Colocando 1, será cobrando a cada 1 mês. Se colocar 6, será cobrando a cada 6 meses.</small>
        </label>
      </p>
      <p>
        <label>
          Meios de pagamento
          <input type="checkbox" class="uk-checkbox" name="" value="">bankslip
        </label>
      </p>
      <p>
        <label>
          Regua de notificação
          <input type="text" class="uk-input" name="regua_de_notificacao_id" value="" required>
        </label>
      </p>
      <p>
        <button style="width: 100%" type="submit" class="uk-button uk-button-primary"> Criar link <span uk-icon="arrow-right"></span> </button>
      </p>
    </form>
  </div>
</div>


<?php require_once('footer.php'); ?>
