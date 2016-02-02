<?php

namespace SGnre\Estados;


class SC extends Estados
{
    private $receita = array(
        0 => 100013, //ICMS Comunicação
        1 => 100021, //ICMS Energia Elétrica
        2 => 100030, //ICMS Transporte
        3 => 100048, //ICMS Substituição Tributária por Apuração
        4 => 100056, //ICMS Importação  (Empresas de courier)
        5 => 100056, //ICMS Importação
        6 => 100064, //ICMS Autuação Fiscal
        7 => 100072, //ICMS Parcelamento
        8 => 100080, //ICMS Recolhimentos Especiais
        9 => 100099, //ICMS Subst. Tributária por Operação
        10 => 100102, //ICMS Consumidor Final Não Contribuinte Outra UF por Operação
        11 => 100110, //ICMS Consumidor Final Não Contribuinte Outra UF por Apuração
        12 => 150010, //ICMS Dívida Ativa
        13 => 600016 //Taxa
    );

    private $produto = array(
        0 => 49, //Álcool Etílico Hidratado
        1 => 3, //Aparelhos Celulares e Cartão Inteligente (Smart Cards e SimCard)
        2 => 43, //Artefatos de Uso Doméstico
        3 => 47, //Artigos de Papelaria
        4 => 81, //Bebidas Quentes
        5 => 40, //Bicicletas e Peças
        6 => 44, //Brinquedos
        7 => 5, //Cervejas, Chopes, Refrigerantes, Água Mineral ou Potável, Bebidas Eletrolíticas (Isotônicas e Energéticas, nbm/sh 2106.90 e 2202.90) e Gelo
        8 => 6, //Cigarros e produtos derivados do fumo
        9 => 7, //Cimento
        10 => 9, //Cosméticos, Perfumaria, Artigos de Higiene Pessoal e de Toucador
        11 => 66, //Derivados de petróleo e demais combustíveis e lubrificantes - exceto alcool etílico anidro, alcool etílico hidratado (AEHC) e biodisel - B100
        12 => 10, //Discos Fonográficos, Fitas Virgens ou Gravadas e Outros Suportes para Reprodução ou Gravação
        13 => 11, //Eletrodomésticos, Eletroeletrônicos e Equipamentos de Informática
        14 => 41, //Ferramentas
        15 => 12, //Filmes Fotográficos e Cinematográficos e Slides
        16 => 42, //Instrumentos Musicais
        17 => 14, //Lâminas de Barbear, Aparelhos de Barbear e Isqueiros de Bolso a Gás não recarregáveis
        18 => 15, //Lâmpadas Elétricas e Eletrônicas, Reatores e Starters
        19 => 45, //Máquinas e Aparelhos Mecânicos, Elétricos, Eletromecânicos e Automáticos
        20 => 16, //Marketing Porta-a-Porta
        21 => 18, //Materiais de Construção, Acabamentos, Bricolagens ou Adornos
        22 => 19, //Materiais de Limpeza
        23 => 46, //Material Elétrico
        24 => 69, //Motocicletas e ciclomotores
        25 => 20, //Peças, Partes, Componentes, Acessórios e demais produtos para Autopropulsados
        26 => 21, //Pilhas, Baterias Elétricas e Acumuladores Elétricos
        27 => 22, //Pneumáticos, Câmaras de ar e Protetores
        28 => 68, //Produtos alimentícios
        29 => 23, //Produtos Farmacêuticos
        30 => 24, //Rações tipo pet para animais domésticos
        31 => 25, //Sorvetes e Preparados para fabricação de sorvete em máquina
        32 => 26, //Suportes Elásticos para cama, Colchões (inclusive Box), Travesseiros e Pillows
        33 => 27, //Tintas, Vernizes e outras mercadorias da indústria química
        34 => 29, //Veículos Automotores Novos de 4 rodas
        35 => 30, //Veículos Automotores Novos Faturamento Direto para o Consumidor
    );

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
        switch ($guia->c02_receita) {
            case 100048:
                if( $guia->c25_detalhamentoReceita === NULL ){
                    throw new \InvalidArgumentException("Quando a receita é 100048 o campo 'c25_detalhamentoReceita' não pode ser NULL para SC");
                }
                $detalhementoReceita = $this->getDetalhamentoReceita($guia->c02_receita);
                if( !in_array( $guia->c25_detalhamentoReceita, $detalhementoReceita) ){
                    throw new \InvalidArgumentException("Esse detalhamento de receita não é valida para SC");
                }
                break;
        }


    }
    /*
     * Método utilizado para validar o código do produto
     * @param \SGnre\Guia  $guia  Um objeto do tipo Guia
     */
    private function validarProduto($guia)
    {
        if( $guia->c02_receita === 100099 ){
            if( $guia->c26_produto === NULL ){
                throw new \InvalidArgumentException("Quando a receita é 100099 o campo 'c26_produto' não pode ser NULL para SC");
            }
            if( !in_array( $guia->c26_produto, $this->produto) ){
                throw new \InvalidArgumentException("Esse código de produto não é valida para SC");
            }
        }
    }

    /*
     * Método utilizado para validar o Numero do Documento de Origem
     * @param \SGnre\Guia  $guia  Um objeto do tipo Guia
     */
    private function validarNumeroDocumentoOrigem($guia)
    {
        switch($guia->c02_receita){
            case 100021:
            case 100030:
            case 100080:
            case 100099:
            case 100102:
            if( $guia->c04_docOrigem === NULL ) throw new \InvalidArgumentException("Quando a receita é 100021,100030,100080,100099,100102 o campo 'c04_docOrigem' não pode ser NULL");
                if( $guia->c28_tipoDocOrigem != 10 ){
                    throw new \InvalidArgumentException("Quando a receita é 100021,100030,100080,100099,100102 o campo 'c28_tipoDocOrigem' tem que ser 10 para SC");
                }
                break;

            case 100056:
                if( $guia->c04_docOrigem === NULL ) throw new \InvalidArgumentException("Quando a receita é 100056 o campo 'c04_docOrigem' não pode ser NULL");
                if( $guia->c28_tipoDocOrigem != 18 && $guia->c28_tipoDocOrigem != 4 && !$guia->c28_tipoDocOrigem != 6 ){
                    throw new \InvalidArgumentException("Quando a receita é 100056 o campo 'c28_tipoDocOrigem' tem que ser 18,4,6 para SC");
                }
                break;

            case 100064:
                if( $guia->c04_docOrigem === NULL ) throw new \InvalidArgumentException("Quando a receita é 100064 o campo 'c04_docOrigem' não pode ser NULL");
                if( $guia->c28_tipoDocOrigem != 16 ){
                    throw new \InvalidArgumentException("Quando a receita é 100064 o campo 'c28_tipoDocOrigem' tem que ser 16 para SC");
                }
                break;

            case 100072:
                if( $guia->c04_docOrigem === NULL ) throw new \InvalidArgumentException("Quando a receita é 100064 o campo 'c04_docOrigem' não pode ser NULL");
                if( $guia->c28_tipoDocOrigem != 17 ){
                    throw new \InvalidArgumentException("Quando a receita é 100072 o campo 'c28_tipoDocOrigem' tem que ser 17 para SC");
                }
                break;

            case 150010:
                if( $guia->c28_tipoDocOrigem != 14 ){
                    throw new \InvalidArgumentException("Quando a receita é 150010 o campo 'c28_tipoDocOrigem' tem que ser 14 para SC");
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
        switch ($guia->c02_receita) {
            case 100013:
                if( $guia->mes === NULL ) throw new \InvalidArgumentException("Quando a receita é 100013 o campo 'mes' não pode ser NULL");
                if( $guia->ano === NULL ) throw new \InvalidArgumentException("Quando a receita é 100013 o campo 'ano' não pode ser NULL");
                if( $guia->c06_valorPrincipal === NULL ) throw new \InvalidArgumentException("Quando a receita é 100013 o campo 'c06_valorPrincipal' não pode ser NULL");
                if( $guia->c17_inscricaoEstadualEmitente === NULL ){
                    if( $guia->c27_tipoIdentificacaoEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100013 o campo 'c27_tipoIdentificacaoEmitente' não pode ser NULL");
                    if( $guia->c03_idContribuinteEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100013 o campo 'c03_idContribuinteEmitente' não pode ser NULL");
                    if( $guia->c16_razaoSocialEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100013 o campo 'c16_razaoSocialEmitente' não pode ser NULL");
                    if( $guia->c18_enderecoEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100013 o campo 'c18_enderecoEmitente' não pode ser NULL");
                    if( $guia->c19_municipioEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100013 o campo 'c19_municipioEmitente' não pode ser NULL");
                    if( $guia->c20_ufEnderecoEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100013 o campo 'c20_ufEnderecoEmitente' não pode ser NULL");
                }
                break;

            case 100021:
            case 100030:
                if( $guia->c10_valorTotal === NULL ) throw new \InvalidArgumentException("Quando a receita é 100021,100030 o campo 'c10_valorTotal' não pode ser NULL");
                if( $guia->c17_inscricaoEstadualEmitente === NULL ){
                    if( $guia->c27_tipoIdentificacaoEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100021,100030 o campo 'c27_tipoIdentificacaoEmitente' não pode ser NULL");
                    if( $guia->c03_idContribuinteEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100021,100030 o campo 'c03_idContribuinteEmitente' não pode ser NULL");
                    if( $guia->c16_razaoSocialEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100021,100030 o campo 'c16_razaoSocialEmitente' não pode ser NULL");
                    if( $guia->c18_enderecoEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100021,100030 o campo 'c18_enderecoEmitente' não pode ser NULL");
                    if( $guia->c19_municipioEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100021,100030 o campo 'c19_municipioEmitente' não pode ser NULL");
                    if( $guia->c20_ufEnderecoEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100021,100030 o campo 'c20_ufEnderecoEmitente' não pode ser NULL");
                }

                break;

            case 100048:
                if( $guia->periodo === NULL ) throw new \InvalidArgumentException("Quando a receita é 100048 o campo 'periodo' não pode ser NULL");
                if( $guia->mes === NULL ) throw new \InvalidArgumentException("Quando a receita é 100048 o campo 'ano' não pode ser NULL");
                if( $guia->ano === NULL ) throw new \InvalidArgumentException("Quando a receita é 100048 o campo 'ano' não pode ser NULL");
                if( $guia->c06_valorPrincipal === NULL ) throw new \InvalidArgumentException("Quando a receita é 100048 o campo 'c06_valorPrincipal' não pode ser NULL");
                if( $guia->c17_inscricaoEstadualEmitente === NULL ){
                    if( $guia->c27_tipoIdentificacaoEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100048 o campo 'c27_tipoIdentificacaoEmitente' não pode ser NULL");
                    if( $guia->c03_idContribuinteEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100048 o campo 'c03_idContribuinteEmitente' não pode ser NULL");
                    if( $guia->c16_razaoSocialEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100048 o campo 'c16_razaoSocialEmitente' não pode ser NULL");
                    if( $guia->c18_enderecoEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100048 o campo 'c18_enderecoEmitente' não pode ser NULL");
                    if( $guia->c19_municipioEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100048 o campo 'c19_municipioEmitente' não pode ser NULL");
                    if( $guia->c20_ufEnderecoEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100048 o campo 'c20_ufEnderecoEmitente' não pode ser NULL");
                }
                break;

            case 100056:
                if( $guia->c06_valorPrincipal === NULL && $guia->c10_valorTotal === NULL ){
                    throw new \InvalidArgumentException("Quando a receita é 100056 não pode os campos 'c06_valorPrincipal', 'c10_valorTotal' estabem hambos NULLs");
                }
                if( $guia->c17_inscricaoEstadualEmitente === NULL ){
                    if( $guia->c27_tipoIdentificacaoEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100056 o campo 'c27_tipoIdentificacaoEmitente' não pode ser NULL");
                    if( $guia->c03_idContribuinteEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100056 o campo 'c03_idContribuinteEmitente' não pode ser NULL");
                    if( $guia->c16_razaoSocialEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100056 o campo 'c16_razaoSocialEmitente' não pode ser NULL");
                    if( $guia->c18_enderecoEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100056 o campo 'c18_enderecoEmitente' não pode ser NULL");
                    if( $guia->c19_municipioEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100056 o campo 'c19_municipioEmitente' não pode ser NULL");
                    if( $guia->c20_ufEnderecoEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100056 o campo 'c20_ufEnderecoEmitente' não pode ser NULL");
                }

                if( $guia->c06_valorPrincipal !== NULL && $guia->c10_valorTotal === NULL ){
                    if( $guia->c36_inscricaoEstadualDestinatario === NULL ){
                        if( $guia->c34_tipoIdentificacaoDestinatario === NULL ) throw new \InvalidArgumentException("Quando a receita é 100056 o campo 'c34_tipoIdentificacaoDestinatario' não pode ser NULL");
                        if( $guia->c35_idContribuinteDestinatario === NULL ) throw new \InvalidArgumentException("Quando a receita é 100056 o campo 'c35_idContribuinteDestinatario' não pode ser NULL");
                        if( $guia->c37_razaoSocialDestinatario === NULL ) throw new \InvalidArgumentException("Quando a receita é 100056 o campo 'c37_razaoSocialDestinatario' não pode ser NULL");
                        if( $guia->c38_municipioDestinatario === NULL ) throw new \InvalidArgumentException("Quando a receita é 100056 o campo 'c38_municipioDestinatario' não pode ser NULL");

                    }
                }
                break;

            case 100064:
                if( $guia->c17_inscricaoEstadualEmitente === NULL ){
                    if( $guia->c27_tipoIdentificacaoEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100064 o campo 'c27_tipoIdentificacaoEmitente' não pode ser NULL");
                    if( $guia->c03_idContribuinteEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100064 o campo 'c03_idContribuinteEmitente' não pode ser NULL");
                    if( $guia->c16_razaoSocialEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100064 o campo 'c16_razaoSocialEmitente' não pode ser NULL");
                    if( $guia->c18_enderecoEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100064 o campo 'c18_enderecoEmitente' não pode ser NULL");
                    if( $guia->c19_municipioEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100064 o campo 'c19_municipioEmitente' não pode ser NULL");
                    if( $guia->c20_ufEnderecoEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100064 o campo 'c20_ufEnderecoEmitente' não pode ser NULL");
                }
                break;

            case 100072:
                if( $guia->parcela === NULL ) throw new \InvalidArgumentException("Quando a receita é 100072 o campo 'parcela' não pode ser NULL");
                if( $guia->c17_inscricaoEstadualEmitente === NULL ){
                    if( $guia->c27_tipoIdentificacaoEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100072 o campo 'c27_tipoIdentificacaoEmitente' não pode ser NULL");
                    if( $guia->c03_idContribuinteEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100072 o campo 'c03_idContribuinteEmitente' não pode ser NULL");
                    if( $guia->c16_razaoSocialEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100072 o campo 'c16_razaoSocialEmitente' não pode ser NULL");
                    if( $guia->c18_enderecoEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100072 o campo 'c18_enderecoEmitente' não pode ser NULL");
                    if( $guia->c19_municipioEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100072 o campo 'c19_municipioEmitente' não pode ser NULL");
                    if( $guia->c20_ufEnderecoEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100072 o campo 'c20_ufEnderecoEmitente' não pode ser NULL");
                }
                break;

            case 100080:
                if( $guia->c10_valorTotal === NULL ) throw new \InvalidArgumentException("Quando a receita é 100080 o campo 'c10_valorTotal' não pode ser NULL");
                if( $guia->c17_inscricaoEstadualEmitente === NULL ){
                    if( $guia->c27_tipoIdentificacaoEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100080 o campo 'c27_tipoIdentificacaoEmitente' não pode ser NULL");
                    if( $guia->c03_idContribuinteEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100080 o campo 'c03_idContribuinteEmitente' não pode ser NULL");
                    if( $guia->c16_razaoSocialEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100080 o campo 'c16_razaoSocialEmitente' não pode ser NULL");
                    if( $guia->c18_enderecoEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100080 o campo 'c18_enderecoEmitente' não pode ser NULL");
                    if( $guia->c19_municipioEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100080 o campo 'c19_municipioEmitente' não pode ser NULL");
                    if( $guia->c20_ufEnderecoEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100080 o campo 'c20_ufEnderecoEmitente' não pode ser NULL");
                }
                break;

            case 100099:
            case 100102:
                if( $guia->c10_valorTotal === NULL ) throw new \InvalidArgumentException("Quando a receita é 100099 o campo 'c10_valorTotal' não pode ser NULL");
                if( $guia->c39_camposExtras['codigo'] != 96 )throw new \InvalidArgumentException("Quando a receita é 100099 o campo 'c39_camposExtras' precisar ter um campo 'codigo' com valor 96");
                if( $guia->c39_camposExtras['tipo'] != 'T' )throw new \InvalidArgumentException("Quando a receita é 100099 o campo 'c39_camposExtras' precisar ter um campo 'tipo' com valor T");
                if( !isset($guia->c39_camposExtras['valor']) )throw new \InvalidArgumentException("Quando a receita é 100099 o campo 'c39_camposExtras' precisar ter um campo 'valor' com a chave na NFE");
                if( $guia->c17_inscricaoEstadualEmitente === NULL ){
                    if( $guia->c27_tipoIdentificacaoEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100099 o campo 'c27_tipoIdentificacaoEmitente' não pode ser NULL");
                    if( $guia->c03_idContribuinteEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100099 o campo 'c03_idContribuinteEmitente' não pode ser NULL");
                    if( $guia->c16_razaoSocialEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100099 o campo 'c16_razaoSocialEmitente' não pode ser NULL");
                    if( $guia->c18_enderecoEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100099 o campo 'c18_enderecoEmitente' não pode ser NULL");
                    if( $guia->c19_municipioEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100099 o campo 'c19_municipioEmitente' não pode ser NULL");
                    if( $guia->c20_ufEnderecoEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100099 o campo 'c20_ufEnderecoEmitente' não pode ser NULL");
                }
                break;

            case 100110:
                if( $guia->c06_valorPrincipal === NULL ) throw new \InvalidArgumentException("Quando a receita é 100110 o campo 'c06_valorPrincipal' não pode ser NULL");
                if( $guia->mes === NULL ) throw new \InvalidArgumentException("Quando a receita é 100110 o campo 'ano' não pode ser NULL");
                if( $guia->c17_inscricaoEstadualEmitente === NULL ){
                    if( $guia->c27_tipoIdentificacaoEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100110 o campo 'c27_tipoIdentificacaoEmitente' não pode ser NULL");
                    if( $guia->c03_idContribuinteEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100110 o campo 'c03_idContribuinteEmitente' não pode ser NULL");
                    if( $guia->c16_razaoSocialEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100110 o campo 'c16_razaoSocialEmitente' não pode ser NULL");
                    if( $guia->c18_enderecoEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100110 o campo 'c18_enderecoEmitente' não pode ser NULL");
                    if( $guia->c19_municipioEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100110 o campo 'c19_municipioEmitente' não pode ser NULL");
                    if( $guia->c20_ufEnderecoEmitente === NULL ) throw new \InvalidArgumentException("Quando a receita é 100110 o campo 'c20_ufEnderecoEmitente' não pode ser NULL");
                }
                break;
        }
    }

    /*
     * Método retorna um array com o detalhamento de receita refente a receitada passada
     * @param Int receita
     */
    private function getDetalhamentoReceita($receita){

        $vetor = array(
            100048 => array(
                0 => '000010', //10022 - Utilizado para recolhimento do imposto postergado por regime especial
                1 => '000011', //10030 - Repasse da refinaria - Combustíveis e outros
                2 => '000012', //10049 - Substituição tributária - prazo normal
                3 => '000013', //10200 - Substituição Tributária - mercadoria desacompanhada de GNRE
                4 => '000014', //10251 - Repasse da refinaria - Combustíveis e outros
                5 => '000015', //10383 - Utilizado para recolhimento da parcela única do imposto, equivalente a 100% do montante devido no mês anterior (ver classe 10391)
                6 => '000016', //10391 - Utilizado para recolhimento do valor remanescente do saldo devedor do imposto (ver classe 10383)
                7 => '000050' //10464 - Substituição Tributária declarado DeSTDA vencimento dia 10 segundo mês.
            ),
            600016 => array(
                0 => '000009' //10 - Petições ou requerimentos dirigidos a autoridades administrativas estaduais
            )
        );

        foreach ($vetor[$receita] as $valor) {
            $detalhmentoReceita[] = $valor;
        }
        return $detalhmentoReceita;
    }
}