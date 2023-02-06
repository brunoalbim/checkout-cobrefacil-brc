# Info

Este sistema permite você disponibilizar um checkout customizado, intuitivo e dinamico para seu usuario enviar pagamentos para você.

Este sistema permite que o proprio cliente digite o valor a ser enviado para você, tornando assim, muito mais facil solicitar pagamentos.


# Como configurar

1. Baixe todos o código deste repositório.
2. Dentro da pasta "app" adicione este arquivo base de configuração: https://github.com/brunoalbim/checkout-cobrefacil-brc-app-config
3. Configure o arquivo "@config.php" como instruções dentro dele.



# Como usar

Caso queira que o cliente digite o valor, não precisa adicionar nenhum parametro na URL.

Caso queira, você tambem pode enviar o link já com o valor, como abaixo:

<code>https://seusite.com.br/?ref={ID_REF}&v={VALOR}&desc={DESCRICAO}</code>

<code>{ID_REF}:</code> Pode ser uma referencia interna sua.
<code>{VALOR}:</code> O valor que deseja receber do cliente. Sendo que o valor deve ter os centavos "sem a virgula". Ex: Para pedir R$150,34 preencha com o valor 15034.
<code>{DESCRICAO}:</code>

Exemplo:
<code>https://seusite.com.br/?ref=PR100&v=15000&desc=Produto+teste</code>



# Usar para assinatura de mensalidade

Caso queira usar para assinaturas de planos ou serviços previamente cadastrados na plataforma cobrefacil, segue abaixo:

<code>https://seusite.com.br/?ref={ID_REF}&desc={DESCRICAO}</code>

<b>OBS:</b> Para usar o sistema de mensalidade, você precisa criar um arquivo chamado "mensalidades.csv" dentro da pasta "app". Você pode baixar o exemplo dentro deste repositório: https://github.com/brunoalbim/checkout-cobrefacil-brc-app-config
