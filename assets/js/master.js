$(document).ready(function() {
  loadMask();
  setTimeout(function() {
    $(".loadspinner").css("display", "none"); $("body").removeClass("body-load");
  }, 800);
});


var SPMaskBehavior = function (val) {
  return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
},
spOptions = {
  onKeyPress: function(val, e, field, options) {
      field.mask(SPMaskBehavior.apply({}, arguments), options);
    }
};

var TelefoneCentral = function (val) {
  return val.replace(/\D/g, '').length === 11 ? '0000 000 0000' : '0000 000 0000';
},
CentralOpcoes = {
  onKeyPress: function(val, e, field, options) {
      field.mask(TelefoneCentral.apply({}, arguments), options);
    }
};


var documentoC = function (val) {
  return val.length === 14 ? '###.###.###-##' : '##.###.###/####-00';
},
documentoOp = {
  onKeyPress: function(val, e, field, options) {
      field.mask(documentoC.apply({}, arguments), options);
    }
};


function semCaracteres(valor){
  var regex = new RegExp("^[a-zA-Z0-9-ZÃ Ã¨Ã¬Ã²Ã¹Ã¡Ã©Ã­Ã³ÃºÃ¢ÃªÃ®Ã´Ã»Ã£Ãµ\b]+$");
  var _this = valor;
  // Curta pausa para esperar colar para completar
  setTimeout( function(){
      var texto = $(_this).val();
      if(!regex.test(texto)) {
        $(_this).val(texto.substring(0, (texto.length-1)));
      }
  }, 100);
}


function loadMask() {
  $(".prefix-url-https").each(function() {
    $(this).prefix("https://");
  });
  $('.money').mask("#.##0,00", {reverse: true});
  $('.cubagem').mask("##000", {reverse: true});
  $('.peso').mask("##0,000", {reverse: true});
  $('.phone').mask(SPMaskBehavior, spOptions);
  $('.phone-0800').mask(TelefoneCentral, CentralOpcoes);
  $('.cpf').mask('000.000.000-00', {reverse: true});
  $('.cnpj').mask('00.000.000/0000-00', {reverse: true});
  $('.documento-formatar').mask(documentoC, documentoOp);
  $('.cep').mask('00000-000');
  $('.date').mask('00/00/0000');
  $('.date-2').mask('00/0000');
  $('.hora-completa').mask('00:00:00');
  console.log("loadMask() Executado");
}


$("#gerar_boleto").submit(function(e) {
  if (!$("input[name='valor']").val()) {
    e.preventDefault();
    UIkit.notification("O campo 'valor' é obrigatório.", {status:'danger'});
  } else {
    $(".loadspinner").css("display", "block"); $("body").addClass("body-load");
  }
});


$("#consultar_documento").submit(function(e) {
  e.preventDefault();
  if ($("input[name='documento']").val()) {

      $('.validar_documento').cpfcnpj({
          mask: false,
          validate: 'cpfcnpj',
          event: 'submit',
          handler: '#consultar_documento',
          ifValid: function (input) {
            $(".loadspinner").css("display", "block"); $("body").addClass("body-load");

            input.removeClass('uk-form-danger');
            input.addClass('uk-form-success');
            $('#info-validate-cpfcnpj').html('<span class="uk-text-success"> &check; Documento valido.</span>');

            $.ajax({
              url: $base_url + "rest/consultar-cliente",
              method: "POST",
              data: {
                documento: $("input[name='documento']").val()
              },
              success: function(id_cliente) {
                if (id_cliente === "nao") {
                  $("#div_cadastrar_cliente").show();
                  $("#div_consultar_documento").hide();
                  setTimeout(function() {
                    $(".loadspinner").css("display", "none"); $("body").removeClass("body-load");
                  }, 800);
                  $("#campo_documento_disabled").val($("input[name='documento']").val());
                  $("input[name='documento_cliente']").val($("input[name='documento']").val());
                } else {
                  if ($("input[name=somentecadastro]").val() === "sim") {
                    window.location.href = $base_url + "cadastrado?id_cliente_cf=" + id_cliente + "&documento=" + $("input[name='documento']").val();
                  } else {
                    window.location.href = $base_url + "?id_cliente_cf=" + id_cliente;
                  }
                }
              },
              error: function() {
                UIkit.notification("Erro no servidor. Contate o suporte.", {status:'danger'});
              }
            });

          },
          ifInvalid: function (input) {
            input.addClass('uk-form-danger');
            input.removeClass('uk-form-success');
            $('#info-validate-cpfcnpj').html('<span class="uk-text-danger"> &times; Documento invalido.</span>');
          }
      });

  } else {
    UIkit.notification("O campo 'CPF/CNPJ' é obrigatório.", {status:'danger'});
  }
});



$("#cadastrar_cliente").submit(function(e) {
  e.preventDefault();
  $(".loadspinner").css("display", "block"); $("body").addClass("body-load");
  $.ajax({
    url: $base_url + "rest/cadastrar-cliente",
    method: "POST",
    data: $("#cadastrar_cliente").serializeArray(),
    success: function(data) {
      data = JSON.parse(data);
      if (data.retorno === "erro") {
        $(".loadspinner").css("display", "none"); $("body").removeClass("body-load");
        UIkit.notification(data.mensagem, {status:'danger'});
      } else {
        if ($("input[name=somentecadastro]").val() === "sim") {
          window.location.href = $base_url + "cadastrado-com-sucesso?id_cliente_cf=" + data.dados;
        } else {
          window.location.href = $base_url + "?id_cliente_cf=" + data.dados;
        }
      }
    },
    error: function() {
      UIkit.notification("Erro no servidor. Contate o suporte.", {status:'danger'});
    }
  });
});



$('.cep').change(function(e){
  e.preventDefault();
    pesquisarCEP($(this));
});
$('.cep').keyup(function(e){
  e.preventDefault();
    pesquisarCEP($(this));
});



// PESQUISAR CEP
function pesquisarCEP($this) {
  var cep = $this.val();
  if (cep.length === 9) {
    $(".loadspinner").css("display", "block"); $("body").addClass("body-load");
    $.get('https://viacep.com.br/ws/'+ cep +'/json/', function(dados) {
      if (dados) {
        $('input[name="logradouro"]').val(dados.logradouro);
        $('input[name="bairro"]').val(dados.bairro);
        $('input[name="cidade"]').val(dados.localidade);
        $('input[name="uf"]').val(dados.uf);
        $(".loadspinner").css("display", "none"); $("body").removeClass("body-load");
      }
    });
  }
}



function primeiraLetraMaiuscula(texto) {
  var frase = $(texto).val();
  var palavra = frase.substring(0,1).toUpperCase().concat(frase.substring(1));
  $(texto).val(palavra);
}

$('.capitalize').change(function(){
  primeiraLetraMaiuscula(this);
});
$('.capitalize').keyup(function(){
  primeiraLetraMaiuscula(this);
});


function ufMaiusculo(texto) {
  var frase = $(texto).val();
  var palavra = frase.substring(0,1).toUpperCase().concat(frase.substring(1));
  var palavra = frase.substring(0,2).toUpperCase().concat(frase.substring(2));
  $(texto).val(palavra);
}

$('.uf').change(function(){
  ufMaiusculo(this);
});
$('.uf').keyup(function(){
  ufMaiusculo(this);
});

$(".limpar-sessao").click(function(e) {
  e.preventDefault();
  location.href = $base_url + "session_destroy";
});
