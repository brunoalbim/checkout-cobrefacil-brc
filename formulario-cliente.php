<div id="div_consultar_documento">
  <center>
    <?php logo_site() ?>
    <h1> <strong>Identifique-se</strong> </h1>
  </center>

  <form id="consultar_documento">
    <input type="hidden" name="somentecadastro" value="<?= $_GET['cadastro'] === "true" ? "sim":"nao" ?>">
    <p>
      <label>
        <input type="tel" class="uk-input documento-formatar validar_documento" placeholder="CPF ou CNPJ" name="documento" value="">
        <span class="uk-margin-remove" id="info-validate-cpfcnpj"></span>
      </label>
    </p>
    <p>
      <button style="width: 100%" type="submit" class="uk-button uk-button-primary"> Proximo passo <span uk-icon="arrow-right"></span> </button>
    </p>
  </form>
</div>


<div id="div_cadastrar_cliente" style="display:none">
  <center>
    <?php logo_site() ?>
    <h1 class="uk-margin-small-bottom"> <strong>Cadastre-se</strong> </h1>
    <p class="uk-margin-small-top"> Preencha os campos abaixo. </p>
  </center>

  <form id="cadastrar_cliente">
    <input type="hidden" name="documento_cliente" value="">
    <input type="hidden" name="somentecadastro" value="<?= $_GET['cadastro'] === "true" ? "sim":"nao" ?>">
    <p>
      <label>
        Documento (CPF ou CNPJ)
        <input id="campo_documento_disabled" type="tel" disabled class="uk-input" required>
      </label>
    </p>
    <p>
      <label>
        Nome e sobrenome ou Razão social
        <input type="text" class="uk-input capitalize" name="nome" value="" required>
      </label>
    </p>
    <p>
      <label>
        Telefone/celular
        <input type="tel" class="uk-input phone" name="telefone" value="" required>
      </label>
    </p>
    <p>
      <label>
        E-mail
        <input type="email" class="uk-input" name="email" value="" required>
      </label>
    </p>
    <p>
      <label>
        CEP
        <input type="tel" class="uk-input cep" name="cep" value="" required>
      </label>
    </p>
    <p>
      <label>
        Endereço
        <input type="text" class="uk-input capitalize" name="logradouro" value="" required>
      </label>
    </p>
    <p>
      <label>
        N°
        <input type="tel" class="uk-input" name="numero" value="" required>
      </label>
    </p>
    <p>
      <label>
        Complemento
        <input type="text" class="uk-input" name="complemento" placeholder="Opcional" value="">
      </label>
    </p>
    <p>
      <label>
        Bairro
        <input type="text" class="uk-input capitalize" name="bairro" value="" required>
      </label>
    </p>
    <p>
      <label>
        Cidade
        <input type="text" class="uk-input capitalize" name="cidade" value="" required>
      </label>
    </p>
    <p>
      <label>
        UF (Estado)
        <input maxlength="2" type="text" class="uk-input uf" name="uf" value="" required>
      </label>
    </p>
    <p>
      <label>
        Tipo do endereço
        <select class="uk-select" name="tipo_endereco" value="" required>
          <option disabled selected>Selecione</option>
          <option>Residencial</option>
          <option>Comercial</option>
          <option>Loja</option>
          <option>Escritório</option>
        </select>
      </label>
    </p>
    <p>
      <button style="width: 100%" type="submit" class="uk-button uk-button-primary"> Proximo passo <span uk-icon="arrow-right"></span> </button>
    </p>
  </form>
</div>
