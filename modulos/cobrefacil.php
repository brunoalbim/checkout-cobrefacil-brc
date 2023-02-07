<?php

class Cobrefacil {

  public function authenticate($credenciais) {

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => $credenciais['url'].'/v1/authenticate',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => json_encode(["app_id" => $credenciais['app_id'], "secret" => $credenciais['secret']]),
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return $response;

  }


  public function gerar_boleto($dados, $authenticate, $credenciais) {

    if ($dados['ref']) {
      $complemento = $dados['descricao'] ? ' - '.$dados['descricao'] : "";
      $descricao_servico = '[REF#: '.$dados['ref'].']'.$complemento;
    } else {
      $descricao_servico = 'Pagamento personalizado';
    }


    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => $credenciais['url'].'/v1/invoices',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>'{
        "reference": "'.$dados['ref'].'",
        "payable_with": "bankslip",
        "customer_id": "'.$dados['id_cliente_cf'].'",
        "due_date": "'.date('Y-m-d', strtotime('+1 days')).'",
        "items": [
            {
                "description": "'.$descricao_servico.'",
                "quantity": 1,
                "price": '.$dados['valor'].'
            }
        ],
        "settings": {
            "warning": {
                "description": "Pague sempre antes do vencimento para não gerar multas. Duvidas, enviar mensagem para '.$credenciais['emailsuporte'].'"
            },
            "send_tax_invoice": 1
        }
    }',
      CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer '.$authenticate['data']['token'],
        'Content-Type: application/json',
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return $response;

  }


  public function gerar_pix($dados, $authenticate, $credenciais) {

    if ($dados['ref']) {
      $complemento = $dados['descricao'] ? ' - '.$dados['descricao'] : "";
      $descricao_servico = '[REF#: '.$dados['ref'].']'.$complemento;
    } else {
      $descricao_servico = 'Pagamento personalizado';
    }

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => $credenciais['url'].'/v1/invoices',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>'{
        "reference": "'.$dados['ref'].'",
        "payable_with": "pix",
        "customer_id": "'.$dados['id_cliente_cf'].'",
        "due_date": "'.date('Y-m-d', strtotime('+1 days')).'",
        "items": [
            {
                "description": "'.$descricao_servico.'",
                "quantity": 1,
                "price": '.$dados['valor'].'
            }
        ],
        "settings": {
            "warning": {
                "description": "Pague sempre antes do vencimento para não gerar multas. Duvidas, enviar mensagem para '.$credenciais['emailsuporte'].'"
            },
            "send_tax_invoice": 1
        }
    }',
      CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer '.$authenticate['data']['token'],
        'Content-Type: application/json',
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return $response;

  }



  public function gerar_cartao($dados, $authenticate, $credenciais) {

    if ($dados['ref']) {
      $complemento = $dados['descricao'] ? ' - '.$dados['descricao'] : "";
      $descricao_servico = '[REF#: '.$dados['ref'].']'.$complemento;
    } else {
      $descricao_servico = 'Pagamento personalizado';
    }

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => $credenciais['url'].'/v1/invoices',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>'{
        "reference": "'.$dados['ref'].'",
        "payable_with": "credit",
        "customer_id": "'.$dados['id_cliente_cf'].'",
        "due_date": "'.date('Y-m-d', strtotime('+1 days')).'",
        "items": [
            {
                "description": "'.$descricao_servico.'",
                "quantity": 1,
                "price": '.$dados['valor'].'
            }
        ],
        "settings": {
            "send_tax_invoice": 1
        }
    }',
      CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer '.$authenticate['data']['token'],
        'Content-Type: application/json',
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return $response;

  }




  public function buscar_cliente_pelo_documento($documento, $authenticate, $credenciais) {
    $curl = curl_init();

    $documento = str_replace(['.','-','/',','], '', $documento);
    $tipo_documento = strlen($documento) === 11 ? "taxpayer_id" : "ein";

    curl_setopt_array($curl, array(
      CURLOPT_URL => $credenciais['url'].'/v1/customers?'.$tipo_documento.'='.$documento,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer '.$authenticate['data']['token'],
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return $response;
  }



  public function cadastrar_cliente($dados, $authenticate, $credenciais) {
    $curl = curl_init();

    $dados_post = [];

    $documento = str_replace(['.','-','/',','], '', $dados['documento_cliente']);
    if (strlen($documento) === 11) {
      $dados_post['person_type'] = 1;
      $dados_post['taxpayer_id'] = $documento;
      $dados_post['personal_name'] = $dados['nome'];
    } else {
      $dados_post['person_type'] = 2;
      $dados_post['ein'] = $documento;
      $dados_post['company_name'] = $dados['nome'];
    }

    $dados_post['telephone'] = str_replace(['(',')',' ','.','-','/',','], '', $dados['telefone']);
    $dados_post['email'] = $dados['email'];

    $dados_post['address']['zipcode'] = str_replace(['.',' ','-'], '', $dados['cep']);
    $dados_post['address']['description'] = $dados['tipo_endereco'];
    $dados_post['address']['street'] = $dados['logradouro'];
    $dados_post['address']['number'] = $dados['numero'];
    $dados_post['address']['complement'] = $dados['complemento'];
    $dados_post['address']['neighborhood'] = $dados['bairro'];
    $dados_post['address']['city'] = $dados['cidade'];
    $dados_post['address']['state'] = $dados['uf'];


    curl_setopt_array($curl, array(
      CURLOPT_URL => $credenciais['url'].'/v1/customers',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => json_encode($dados_post),
      CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer '.$authenticate['data']['token'],
        'Content-Type: application/json',
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return $response;
  }







  public function gerar_mensalidade($dados, $authenticate, $credenciais) {

    $dados_post['customer_id'] = $dados['id_cliente_cf'];
    $dados_post['first_due_date'] = date('Y-m-d', strtotime('+1 days'));
    $dados_post['reference'] = 'none';
    $dados_post['generate_days'] = '1';
    $dados_post['interval_size'] = $dados['intervalo_cobranca'];
    $dados_post['payable_with'] = $dados['meios_de_pagamento'];
    $dados_post['notification_rule_id'] = $credenciais['regua_de_notificacao_id'];
    $dados_post['settings']['warning']['description'] = "Pague sempre antes do vencimento para não gerar multas. Duvidas, enviar mensagem para ".$credenciais['emailsuporte'];
    $dados_post['settings']['send_tax_invoice'] = "1";

    if ($dados['plano_ou_servico'] === 'plano') {
      $dados_post['plans_id'] = $dados['plano_id'];
    } else {
      $dados_post['items'][0]['products_services_id'] = $dados['plano_id'];
    }

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => $credenciais['url'].'/v1/subscriptions',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => json_encode($dados_post),
      CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer '.$authenticate['data']['token'],
        'Content-Type: application/json',
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return $response;

  }





  public function gerar_cobranca_mensalidade($id, $authenticate, $credenciais) {

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => $credenciais['url'].'/v1/subscriptions/'.$id.'/generate-invoice',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer '.$authenticate['data']['token'],
        'Content-Type: application/json',
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return $response;

  }






  public function buscar_plano($planoid, $authenticate, $credenciais) {

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => $credenciais['url'].'/v1/plans/'.$planoid,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer '.$authenticate['data']['token'],
        'Content-Type: application/json',
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return $response;

  }








  public function buscar_servico($planoid, $authenticate, $credenciais) {

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => $credenciais['url'].'/v1/product-services/'.$planoid,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer '.$authenticate['data']['token'],
        'Content-Type: application/json',
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return $response;

  }








  public function buscar_fatura($id, $authenticate, $credenciais) {

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => $credenciais['url'].'/v1/invoices/'.$id,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer '.$authenticate['data']['token'],
        'Content-Type: application/json',
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return $response;

  }


}
