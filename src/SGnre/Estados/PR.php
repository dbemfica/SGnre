<?php

namespace SGnre\Estados;


class PR extends Estados
{
    private $receita = array(
        0 => 100013, //ICMS Comunicação
        1 => 100021, //ICMS Energia Elétrica
        2 => 100030, //ICMS Transporte
        3 => 100048, //ICMS Substituição Tributária por Apuração
        4 => 100056, //ICMS Importação  (Empresas de courier)
        5 => 100056, //ICMS Importação
        6 => 100099, //ICMS Subst. Tributária por Operação
        7 => 100102, //ICMS Consumidor Final Não Contribuinte Outra UF por Operação
        8 => 100110, //ICMS Consumidor Final Não Contribuinte Outra UF por Apuração
    );

    private $produto = array();

    /*
    * Método utilizado para validar a guia
    * @param \SGnre\Guia  $guia  Um objeto do tipo Guia
    */
    public function validar(\SGnre\Guia $guia)
    {
        $this->validarDetalhmentoReceita($guia);
        $this->validarReceita($guia->c02_receita);
        $this->validarProduto($guia);
        $this->validarNumeroDocumentoOrigem($guia);
        $this->validarOutras($guia);
    }

    /*
     * Método utilizado para validar se receita é valida para este estado
     * @param Int receita
     */
    private function validarReceita($receita)
    {
        if( !in_array($receita, $this->receita) ){
            throw new \InvalidArgumentException("Essa receita não é valida para SC");
        }
    }

    /*
     * Método utilizado para validar o detalhamento de receita
     * @param \SGnre\Guia  $guia  Um objeto do tipo Guia
     */
    private function validarDetalhmentoReceita($guia)
    {
    }

    /*
     * Método utilizado para validar o código do produto
     * @param \SGnre\Guia  $guia  Um objeto do tipo Guia
     */
    private function validarProduto($guia)
    {
    }

    /*
     * Método utilizado para validar o Numero do Documento de Origem
     * @param \SGnre\Guia  $guia  Um objeto do tipo Guia
     */
    private function validarNumeroDocumentoOrigem($guia)
    {
        switch($guia->c02_receita){
            case 100056:
                if( $guia->c04_docOrigem === NULL ) throw new \InvalidArgumentException("Quando a receita é 100056 o campo 'c04_docOrigem' não pode ser NULL");
                if( $guia->c10_valorTotal !== NULL && $guia->c06_valorPrincipal !== NULL ){
                    throw new \InvalidArgumentException("Quando a receita é 100056 você tem que escolher o 'c10_valorTotal' ou 'c06_valorPrincipal'");
                }
                if( $guia->c39_camposExtras !== NULL ){
                    if( $guia->c28_tipoDocOrigem != '04' && !$guia->c28_tipoDocOrigem != '06' ){
                        throw new \InvalidArgumentException("Quando a receita é 100056 o campo 'c28_tipoDocOrigem' tem que ser 4,6 para PR");
                    }
                }
                if( $guia->c39_camposExtras === NULL ){
                    if( $guia->c28_tipoDocOrigem != 18 ){
                        throw new \InvalidArgumentException("Quando a receita é 100056 o campo 'c28_tipoDocOrigem' tem que ser 18 para PR");
                    }
                }
                break;

            case 100099:
            case 100102:
                if( $guia->c04_docOrigem === NULL ) throw new \InvalidArgumentException("Quando a receita é 100099,100102 o campo 'c04_docOrigem' não pode ser NULL");
                if( $guia->c28_tipoDocOrigem != 10 ){
                    throw new \InvalidArgumentException("Quando a receita é 100099,100102 o campo 'c28_tipoDocOrigem' tem que ser 10 para PR");
                }
                break;
        }
    }

    /*
     * Método utilizado para validar o Outras Informações
     * @param \SGnre\Guia  $guia  Um objeto do tipo Guia
     */
    private function validarOutras($guia)
    {
        if( $guia->c17_inscricaoEstadualEmitente === NULL ){
            if( $guia->c27_tipoIdentificacaoEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100013 o campo 'c27_tipoIdentificacaoEmitente' não pode ser NULL");
            if( $guia->c03_idContribuinteEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100013 o campo 'c03_idContribuinteEmitente' não pode ser NULL");
            if( $guia->c16_razaoSocialEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100013 o campo 'c16_razaoSocialEmitente' não pode ser NULL");
            if( $guia->c18_enderecoEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100013 o campo 'c18_enderecoEmitente' não pode ser NULL");
            if( $guia->c19_municipioEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100013 o campo 'c19_municipioEmitente' não pode ser NULL");
            if( $guia->c20_ufEnderecoEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100013 o campo 'c20_ufEnderecoEmitente' não pode ser NULL");
        }

        switch ($guia->c02_receita) {
            case 100013:
            case 100021:
            case 100030:
            case 100048:
            case 100110:
                if( $guia->periodo === NULL ) throw new \InvalidArgumentException("Quando a receita é 100013,100021,100030 o campo 'periodo' não pode ser NULL");
                if( $guia->mes === NULL ) throw new \InvalidArgumentException("Quando a receita é 100013,100021,100030 o campo 'mes' não pode ser NULL");
                if( $guia->ano === NULL ) throw new \InvalidArgumentException("Quando a receita é 100013,100021,100030 o campo 'ano' não pode ser NULL");
                if( $guia->c06_valorPrincipal === NULL ) throw new \InvalidArgumentException("Quando a receita é 100013,100021,100030 o campo 'c06_valorPrincipal' não pode ser NULL");
                break;

            case 100056:
                if( $guia->c06_valorPrincipal === NULL ){
                    throw new \InvalidArgumentException("Quando a receita é 100056 não pode os campos 'c06_valorPrincipal' estabem hambos NULLs");
                }

                if( $guia->c39_camposExtras === NULL ){
                    if( $guia->c36_inscricaoEstadualDestinatario === NULL ){
                        if( $guia->c34_tipoIdentificacaoDestinatario === NULL ) throw new \InvalidArgumentException("Quando a receita é 100056 o campo 'c34_tipoIdentificacaoDestinatario' não pode ser NULL");
                        if( $guia->c35_idContribuinteDestinatario === NULL ) throw new \InvalidArgumentException("Quando a receita é 100056 o campo 'c35_idContribuinteDestinatario' não pode ser NULL");
                        if( $guia->c37_razaoSocialDestinatario === NULL ) throw new \InvalidArgumentException("Quando a receita é 100056 o campo 'c37_razaoSocialDestinatario' não pode ser NULL");
                        if( $guia->c38_municipioDestinatario === NULL ) throw new \InvalidArgumentException("Quando a receita é 100056 o campo 'c38_municipioDestinatario' não pode ser NULL");
                    }
                }
                $codigo = $this->getCodigoCampoExtra(100056);
                foreach( $guia->c39_camposExtras as $camposExtras ){
                    if( !in_array( $camposExtras['codigo'], $codigo) ){
                        throw new \InvalidArgumentException("O código do campo extra está invalido para a receita 100056");
                    }
                    if( $camposExtras['tipo'] != 'T' ) throw new \InvalidArgumentException("Quando a receita é 100056 o campo 'c39_camposExtras' precisar ter um campo 'tipo' com valor T");
                    if( !isset($camposExtras['valor']) )throw new \InvalidArgumentException("Quando a receita é 100056 o campo 'c39_camposExtras' precisar ter um campo 'valor'");
                }
                break;

            case 100099:
                if( $guia->c06_valorPrincipal === NULL ) throw new \InvalidArgumentException("Quando a receita é 100099 o campo 'c06_valorPrincipal' não pode ser NULL");

                $codigo = $this->getCodigoCampoExtra(100099);
                foreach( $guia->c39_camposExtras as $camposExtras ){
                    if( !in_array( $camposExtras['codigo'], $codigo) ){
                        throw new \InvalidArgumentException("O código do campo extra está invalido para a receita 100099");
                    }
                    if( $camposExtras['tipo'] != 'T' ) throw new \InvalidArgumentException("Quando a receita é 100099 o campo 'c39_camposExtras' precisar ter um campo 'tipo' com valor T");
                    if( !isset($camposExtras['valor']) )throw new \InvalidArgumentException("Quando a receita é 100099 o campo 'c39_camposExtras' precisar ter um campo 'valor'");
                }
                break;

            case 100102:
                if( $guia->c06_valorPrincipal === NULL ) throw new \InvalidArgumentException("Quando a receita é 100102 o campo 'c06_valorPrincipal' não pode ser NULL");

                $codigo = $this->getCodigoCampoExtra(100102);
                foreach( $guia->c39_camposExtras as $camposExtras ){
                    if( !in_array( $camposExtras['codigo'], $codigo) ){
                        throw new \InvalidArgumentException("O código do campo extra está invalido para a receita 100102");
                    }
                    if( $camposExtras['tipo'] != 'T' ) throw new \InvalidArgumentException("Quando a receita é 100102 o campo 'c39_camposExtras' precisar ter um campo 'tipo' com valor T");
                    if( !isset($camposExtras['valor']) )throw new \InvalidArgumentException("Quando a receita é 100102 o campo 'c39_camposExtras' precisar ter um campo 'valor'");
                }
                break;
        }
    }

    /*
     * Método retorna um array com os códigos possiveis para o campo extra dependento da receita passada
     * @param Int receita
     */
    private function getCodigoCampoExtra($receita){
        $vetor = array(
            100099 => array(
                0 => '61',
                1 => '65'
            ),
            100102 => array(
                0 => '66',
                1 => '61',
                2 => '65'
            ),
            100056 => array(
                0 => '61',
                1 => '65',
                2 => '67'
            )
        );

        foreach ($vetor[$receita] as $valor) {
            $codigo[] = $valor;
        }
        return $codigo;
    }
}