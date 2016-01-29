<?php

namespace SGnre;

class Guia
{

    /*
     * Contém a sigla da UF favorecida. Campo com 2 dígitos.
     */
    private $c01_ufFavorecida;

    /*
     * Contém o código da receita. Campo numérico com 6 dígitos.
     * (Consultar na aba 'Regras de Preenchimento')
     */
    private $c02_receita;

    /*
     * Contém o código do detalhamento da receita. Campo numérico.
     * A quantidade de dígitos corresponde a quantidade de dígitos do código.
     * (Consultar na aba 'Regras de Preenchimento').
     */
    private $c25_detalhamentoReceita;

    /*
     * Contém o código do produto. Campo numérico.
     * A quantidade de dígitos corresponde a quantidade de dígitos do código.
     * (Consultar na aba 'Regras de Preenchimento').
     */
    private $c26_produto;

    /*
     * Contém o código do tipo de identificação do contribuinte emitente (Responsável pelo Pagamento do Tributo).
     * Campo numérico com 1 dígito.
     * (Ver ANEXO 2, na aba 'Anexos').
     * Caso a identificação seja pela inscrição estadual, esse campo e sua tag poderão ser omitidos.
     */
    private $c27_tipoIdentificacaoEmitente;

    /*
     * Contém o número do documento de identificação do contribuinte emitente.
     * O CPF/ CNPJ não deverá conter espaços, pontos ou traços e apenas um documento poderá ser colocado no arquivo.
     * Caso a identificação seja pela inscrição estadual, esse campo e sua tag poderão ser omitidos.
     * Caso a identificação seja pelo CNPJ, a tag de CPF e de Inscrição Estadual poderão ser omitidas.
     * Caso a identificação seja pelo CPF, os campos e as tags de CNPJ e de Inscrição Estadual poderão ser omitidos.
     * Exemplos:
     * CNPJ : <CNPJ>11111111111111</CNPJ>
     * CPF : <CPF>11111111111</CPF>
     */
    private $c03_idContribuinteEmitente;

    /*
     * Contém o código do tipo de documento de origem. Campo numérico.
     * A quantidade de dígitos corresponde a quantidade de dígitos do código.
     * (Consultar na aba 'Regras de Preenchimento').
     * Caso a receita não exija documento de origem, esse campo e sua tag poderão ser omitidos.
     */
    private $c28_tipoDocOrigem;

    /*
     * Contém o número contido no documento de origem.
     * Campo numérico sem espaços, traços, pontos ou vírgulas.
     * A quantidade de dígitos corresponde a quantidade de dígitos do número.
     * Caso a receita não exija documento de origem, esse campo e sua tag poderão ser omitidos.
     */
    private $c04_docOrigem;

    /*
     * Contém o valor original da guia. Digitar apenas números.
     * Usar ponto (".") como separador de decimal, e este deve ter 2 números.
     * Caso a receita não exija valor principal, esse campo e sua tag poderão ser omitidos.
     * Exemplo1 para o valor de R$1.000,00:
     * <c06_valorPrincipal>1000.00</c06_valorPrincipal>
     * Exemplo2 para o valor de R$52,20:
     * <c06_valorPrincipal>52.20</c06_valorPrincipal>
     */
    private $c06_valorPrincipal;

    /*
     * Contém valor total da guia (valor original + encargos).
     * Digitar apenas números.
     * Usar ponto (".") como separador de decimal, e este deve ter 2 números.
     * Caso a receita não exija valor total, esse campo e sua tag poderão ser omitidos.
     * Para calcular os encargos, procurar informações na Sefaz do Estado da UF favorecida.
     * Exemplo1 para o valor de R$1.000,00:
     * <c10_valorTotal>1000.00</c10_valorTotal>
     * Exemplo2 para o valor de R$52,20:
     * <c10_valorTotal>52.20</c10_valorTotal>
     */
    private $c10_valorTotal;

    /*
     * Contém a data que o contribuinte deve pagar o tributo de acordo com a legislação de cada UF.
     * Formato: AAAA-MM-DD.
     * Exemplo:
     * <c14_dataVencimento>2010-04-10</c14_dataVencimento>
     */
    private $c14_dataVencimento;

    /*
     * Contém o número do convênio. Sem espaços, traços, pontos ou vírgulas.
     * Este campo não é obrigatório e o tamanho do campo corresponde ao número do convênio.
     * No caso de não ter essa informação, esse campo e sua tag poderão ser omitidos.
     */
    private $c15_convenio;

    /*
     * Contém o nome da razão social do contribuinte emitente.
     * No caso da identificação do contribuinte ser por inscrição estadual, esse campo e sua tag poderão ser omitidos.
     */
    private $c16_razaoSocialEmitente;

    /*
     * Contém a inscrição estadual do contribuinte emitente na UF favorecida.
     * Campo numérico sem espaços ou traços.
	 * Caso seja inscrito na UF Favorecida, preencher este campo.
     * Caso contrário, esse campo e sua tag poderão ser omitidos.
     */
    private $c17_inscricaoEstadualEmitente;

    /*
     * Contém o endereço do contribuinte emitente.
     * No caso da identificação do contribuinte ser por inscrição estadual, esse campo e sua tag poderão ser omitidos.
     */
    private $c18_enderecoEmitente;

    /*
     * Contém o código do município de localização do contribuinte emitente.
     * Campo numérico. (Consultar no site do IBGE).
     * O IBGE informará o código do município no formato "EEmmmmd".
     * Tirar os 2 primeiros números que indicam o número do Estado e só colocar os 5 números restantes, ficando no formato "mmmmd".
     * Exemplo:
     * A cidade Recife tem o código 2611606, você tirará os dígitos "26" e colocará no arquivo de lote apenas os dígitos "11606".
     * No caso da identificação do contribuinte ser por inscrição estadual, esse campo e sua tag poderão ser omitidos.
     */
    private $c19_municipioEmitente;

    /*
     * Contém a UF de localização do contribuinte emitente.
     * Campo com 2 dígitos.
     * (Ver ANEXO 1, na aba 'Anexos'). No caso da identificação do contribuinte ser por inscrição estadual, esse campo e sua tag poderão ser omitidos.
     */
    private $c20_ufEnderecoEmitente;

    /*
     * Contém o CEP do contribuinte emitente com 8 dígitos.
     * Digitar apenas números. Esse campo não é obrigatório.
     * No caso da identificação do contribuinte ser por inscrição estadual, esse campo e sua tag poderão ser omitidos.
     */
    private $c21_cepEmitente;

    /*
     * Contém o telefone do contribuinte emitente. Colocar o DDD e o número do telefone. Digitar apenas números.
     * Esse campo não é obrigatório.
     * No caso de não ter essa informação, esse campo e sua tag poderão ser omitidos.
     * Exemplo:
     * <c22_telefoneEmitente>1122222222</c22_telefoneEmitente>
     * Onde: 11 => DDD e 22222222 => Telefone
     */
    private $c22_telefoneEmitente;

    /*
     * Contém o código do tipo de identificação do contribuinte destinatário.
     * Campo numérico com 1 dígito. (Ver ANEXO 2, na aba 'Anexos').
     * Caso a receita não exija destinatário, esse campo e sua tag poderão ser omitidos.
     */
    private $c34_tipoIdentificacaoDestinatario;

    /*
     * Contém o número do documento de identificação do contribuinte destinatário.
     * O CPF/ CNPJ não deverá conter espaços, pontos ou traços e apenas um documento poderá ser colocado no arquivo.
     * Caso a receita não exija destinatário, esse campo e sua tag poderão ser omitidos.
     * Exemplos:
     * CNPJ : <CNPJ>11111111111111</CNPJ>
     * CPF : <CPF>11111111111</CPF>
     */
    private $c35_idContribuinteDestinatario;

    /*
     * Contém a inscrição estadual do contribuinte destinatário.
     * Campo numérico sem espaços ou traços.
     * Caso seja inscrito na UF Favorecida, preencher este campo.
     * Caso a receita não exija destinatário, esse campo e sua tag poderão ser omitidos.
     */
    private $c36_inscricaoEstadualDestinatario;

    /*
     * Contém o nome da firma ou a razão social do contribuinte destinatário.
     * Caso a receita não exija destinatário, esse campo e sua tag poderão ser omitidos.
     */
    private $c37_razaoSocialDestinatario;

    /*
     * Contém o município de localização do contribuinte destinatário.
     * Campo numérico.
     * (Consultar no site do IBGE).
     * O IBGE informará o código do município no formato "EEmmmmd".
     * Tirar os 2 primeiros números que indicam o número do Estado e só colocar os 5 números restantes, ficando no formato "mmmmd".
     * Exemplo:
     * A cidade Recife tem o código 2611606, você tirará os dígitos "26" e colocará no arquivo de lote apenas os dígitos "11606".
     * Caso a receita não exija destinatário, esse campo e sua tag poderão ser omitidos.
     */
    private $c38_municipioDestinatario;

    /*
     * Contém a data que o contribuinte irá pagar o tributo.Formato: AAAA-MM-DD.
     * Exemplo:
     * <c33_dataPagamento>2010-04-10</c33_dataPagamento>
     */
    private $c33_dataPagamento;

    /*
     * Contém as informações do período de referência.
     * Caso a receita não exija período de referência, esse campo e sua tag poderão ser omitidos.
     */
    private $c05_referencia;

    /*
     * Contém o código do período.
     * Campo numérico.
     * A quantidade de dígitos corresponde a quantidade de dígitos do código.
     * (Consultar na aba 'Regras de Preenchimento').
     * Caso a receita não exija código do período, esse campo e sua tag poderão ser omitidos
     */
    private $periodo;

    /*
     * Contém o mês de referência da apuração.
     * Campo numérico com 2 dígitos.
     * (Ver ANEXO 3, na aba 'Anexos').
     * Caso a receita não exija mês de período de referência, esse campo e sua tag poderão ser omitidos.
     */
    private $mes;

    /*
     * Contém o ano de referência da apuração.
     * Campo numérico com 4 dígitos.
     * Caso a receita não exija ano de período de referência, esse campo e sua tag poderão ser omitidos.
     */
    private $ano;

    /*
     * Contém o número da parcela do débito.
     * Campo numérico com tamanho máximo de 3 dígitos.
     * Caso a receita não exija parcela no período de referência, esse campo e sua tag poderão ser omitidos.
     */
    private $parcela;

    /*
     * Lista de campos extras (array).
     * Poderá ter no máximo 3 campos extras por guia.
     * Caso a receita não exija campos extras, esse campo e sua tag poderão ser omitidos.
     */
    private $c39_camposExtras;

    /*
     * Contém o código do campo extra.
     * Campo numérico.
     * A quantidade de dígitos corresponde a quantidade de dígitos do código.
     * (Consultar na aba 'Regras de Preenchimento').
     * Caso a receita não exija campos extras, esse campo e sua tag poderão ser omitidos.
     */
    private $codigo;

    /*
     * Contém o tipo do campo extra.
     * Campo com um caracter.
     * (Consultar na aba 'Regras de Preenchimento').
     * Caso a receita não exija campos extras, esse campo e sua tag poderão ser omitidos.
     */
    private $tipo;

    /*
     * Contém o valor solicitado no campo extra.
     * Se for do tipo Data 'D', o formato é: AAAA-MM-DD.
     * Se for do tipo Númerico 'N', usar ponto (".") como separador de decimal, e este deve ter 2 números.
     * Exemplo:
     * <valor>15.40</valor>
     * Para o valor = R$15,40
     * Caso a receita não exija campos extras, esse campo e sua tag poderão ser omitidos.
     */
    private $valor;

    /*
     * Contém o identificador da guia no lote.
     * O valor deste campo deverá ser informado pelo contribuinte para a identificação da guia.
     * Esta informação é opcional e deve conter apenas números (até 10 posições).
     */
    private $c42_identificadorGuia;


    public function __set($property, $value)
    {
        $this->$property = $value;
        return true;
    }
    public function __get($property)
    {
        return $this->$property;
    }
}