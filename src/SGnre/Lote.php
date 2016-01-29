<?php

namespace SGnre;

class Lote
{
    private $dom;
    private $xml;
    private $guias = array();

    public function __construct()
    {
        $this->dom = new \DOMDocument('1.0', 'UTF-8');
        $this->dom->formatOutput = false;
        $this->dom->preserveWhiteSpace = false;
        $this->getHeader();
    }

    private function getHeader()
    {
        $lote = $this->dom->createElement('TLote_GNRE');
        $lote->setAttribute('xmlns', 'http://www.gnre.pe.gov.br');
        $lote->setAttribute('versao', '1.00');

        return $lote;
    }

    private function getBody($lote)
    {
        $guias = $this->dom->createElement('guias');
        $lote->appendChild($guias);

        foreach( $this->guias as $guia ){
            $tDadosGnre = $this->dom->createElement('TDadosGnre');

            if( $guia->c01_ufFavorecida !== NULL )                  $c1 = $this->dom->createElement("c01_ufFavorecida",$guia->c01_ufFavorecida);
            if( $guia->c02_receita !== NULL )                       $c2 = $this->dom->createElement("c02_receita",$guia->c02_receita);
            if( $guia->c25_detalhamentoReceita !== NULL )           $c25 = $this->dom->createElement("c25_detalhamentoReceita",$guia->c25_detalhamentoReceita);
            if( $guia->c26_produto !== NULL )                       $c26 = $this->dom->createElement("c26_produto",$guia->c26_produto);
            if( $guia->c27_tipoIdentificacaoEmitente !== NULL )     $c27 = $this->dom->createElement("c27_tipoIdentificacaoEmitente",$guia->c27_tipoIdentificacaoEmitente);
            if( $guia->c03_idContribuinteEmitente !== NULL )        $c3 = $this->dom->createElement("c03_idContribuinteEmitente",$guia->c03_idContribuinteEmitente);
            if( $guia->c28_tipoDocOrigem !== NULL )                 $c28 = $this->dom->createElement("c28_tipoDocOrigem",$guia->c28_tipoDocOrigem);
            if( $guia->c04_docOrigem !== NULL )                     $c4 = $this->dom->createElement("c04_docOrigem",$guia->c04_docOrigem);
            if( $guia->c06_valorPrincipal !== NULL )                $c6 = $this->dom->createElement("c06_valorPrincipal",$guia->c06_valorPrincipal);
            if( $guia->c10_valorTotal !== NULL )                    $c10 = $this->dom->createElement("c10_valorTotal",$guia->c10_valorTotal);
            if( $guia->c14_dataVencimento !== NULL )                $c14 = $this->dom->createElement("c14_dataVencimento",$guia->c14_dataVencimento);
            if( $guia->c15_convenio !== NULL )                      $c15 = $this->dom->createElement("c15_convenio",$guia->c15_convenio);
            if( $guia->c16_razaoSocialEmitente !== NULL )           $c16 = $this->dom->createElement("c16_razaoSocialEmitente",$guia->c16_razaoSocialEmitente);
            if( $guia->c17_inscricaoEstadualEmitente !== NULL )     $c17 = $this->dom->createElement("c17_inscricaoEstadualEmitente",$guia->c17_inscricaoEstadualEmitente);
            if( $guia->c18_enderecoEmitente !== NULL )              $c18 = $this->dom->createElement("c18_enderecoEmitente",$guia->c18_enderecoEmitente);
            if( $guia->c19_municipioEmitente !== NULL )             $c19 = $this->dom->createElement("c19_municipioEmitente",$guia->c19_municipioEmitente);
            if( $guia->c20_ufEnderecoEmitente !== NULL )            $c20 = $this->dom->createElement("c20_ufEnderecoEmitente",$guia->c20_ufEnderecoEmitente);
            if( $guia->c21_cepEmitente !== NULL )                   $c21 = $this->dom->createElement("c21_cepEmitente",$guia->c21_cepEmitente);
            if( $guia->c22_telefoneEmitente !== NULL )              $c22 = $this->dom->createElement("c22_telefoneEmitente",$guia->c22_telefoneEmitente);
            if( $guia->c34_tipoIdentificacaoDestinatario !== NULL ) $c34 = $this->dom->createElement("c34_tipoIdentificacaoDestinatario",$guia->c34_tipoIdentificacaoDestinatario);
            if( $guia->c35_idContribuinteDestinatario !== NULL )    $c35 = $this->dom->createElement("c35_idContribuinteDestinatario",$guia->c35_idContribuinteDestinatario);
            if( $guia->c36_inscricaoEstadualDestinatario !== NULL ) $c36 = $this->dom->createElement("c36_inscricaoEstadualDestinatario",$guia->c36_inscricaoEstadualDestinatario);
            if( $guia->c37_razaoSocialDestinatario !== NULL )       $c37 = $this->dom->createElement("c37_razaoSocialDestinatario",$guia->c37_razaoSocialDestinatario);
            if( $guia->c38_municipioDestinatario !== NULL )         $c38 = $this->dom->createElement("c38_municipioDestinatario",$guia->c38_municipioDestinatario);
            if( $guia->c33_dataPagamento !== NULL )                 $c33 = $this->dom->createElement("c33_dataPagamento",$guia->c33_dataPagamento);
            if( $guia->c05_referencia !== NULL )                    $c5 = $this->dom->createElement("c05_referencia",$guia->c05_referencia);
            if( $guia->periodo !== NULL )                           $periodo = $this->dom->createElement("periodo",$guia->periodo);
            if( $guia->mes !== NULL )                               $mes = $this->dom->createElement("mes",$guia->mes);
            if( $guia->ano !== NULL )                               $ano = $this->dom->createElement("mes",$guia->ano);
            if( $guia->parcela !== NULL )                           $parcela = $this->dom->createElement("parcela",$guia->parcela);
            if( !empty($guia->c39_campoExtra) ){
                $c39 = $this->dom->createElement("c39_campoExtra");
                $c39_aux = $this->dom->createElement("campoExtra");
                foreach( $guia->c39_campoExtra as $k => $v ){
                    $aux = $this->dom->createElement($k,$v);
                    $c39_aux->appendChild($aux);
                }
                $c39->appendChild($c39_aux);
            }
            if( $guia->codigo !== NULL )                            $codigo = $this->dom->createElement("codigo",$guia->codigo);
            if( $guia->tipo !== NULL )                              $tipo = $this->dom->createElement("tipo",$guia->tipo);
            if( $guia->valor !== NULL )                             $valor = $this->dom->createElement("valor",$guia->valor);

            if( $guia->c01_ufFavorecida !== NULL )                  $tDadosGnre->appendChild($c1);
            if( $guia->c02_receita !== NULL )                       $tDadosGnre->appendChild($c2);
            if( $guia->c25_detalhamentoReceita !== NULL )           $tDadosGnre->appendChild($c25);
            if( $guia->c26_produto !== NULL )                       $tDadosGnre->appendChild($c26);
            if( $guia->c27_tipoIdentificacaoEmitente !== NULL )     $tDadosGnre->appendChild($c27);
            if( $guia->c03_idContribuinteEmitente !== NULL )        $tDadosGnre->appendChild($c3);
            if( $guia->c28_tipoDocOrigem !== NULL )                 $tDadosGnre->appendChild($c28);
            if( $guia->c04_docOrigem !== NULL )                     $tDadosGnre->appendChild($c4);
            if( $guia->c06_valorPrincipal !== NULL )                $tDadosGnre->appendChild($c6);
            if( $guia->c10_valorTotal !== NULL )                    $tDadosGnre->appendChild($c10);
            if( $guia->c14_dataVencimento !== NULL )                $tDadosGnre->appendChild($c14);
            if( $guia->c15_convenio !== NULL )                      $tDadosGnre->appendChild($c15);
            if( $guia->c16_razaoSocialEmitente !== NULL )           $tDadosGnre->appendChild($c16);
            if( $guia->c17_inscricaoEstadualEmitente !== NULL )     $tDadosGnre->appendChild($c17);
            if( $guia->c18_enderecoEmitente !== NULL )              $tDadosGnre->appendChild($c18);
            if( $guia->c19_municipioEmitente !== NULL )             $tDadosGnre->appendChild($c19);
            if( $guia->c20_ufEnderecoEmitente !== NULL )            $tDadosGnre->appendChild($c20);
            if( $guia->c21_cepEmitente !== NULL )                   $tDadosGnre->appendChild($c21);
            if( $guia->c22_telefoneEmitente !== NULL )              $tDadosGnre->appendChild($c22);
            if( $guia->c34_tipoIdentificacaoDestinatario !== NULL ) $tDadosGnre->appendChild($c34);
            if( $guia->c35_idContribuinteDestinatario !== NULL )    $tDadosGnre->appendChild($c35);
            if( $guia->c36_inscricaoEstadualDestinatario !== NULL ) $tDadosGnre->appendChild($c36);
            if( $guia->c37_razaoSocialDestinatario !== NULL )       $tDadosGnre->appendChild($c37);
            if( $guia->c38_municipioDestinatario !== NULL )         $tDadosGnre->appendChild($c38);
            if( $guia->c33_dataPagamento !== NULL )                 $tDadosGnre->appendChild($c33);
            if( $guia->c05_referencia !== NULL )                    $tDadosGnre->appendChild($c5);
            if( $guia->periodo !== NULL )                           $tDadosGnre->appendChild($periodo);
            if( $guia->mes !== NULL )                               $tDadosGnre->appendChild($mes);
            if( $guia->ano !== NULL )                               $tDadosGnre->appendChild($ano);
            if( $guia->parcela !== NULL )                           $tDadosGnre->appendChild($parcela);
            if( !empty($guia->c39_campoExtra) )                     $tDadosGnre->appendChild($c39);
            if( $guia->codigo !== NULL )                            $tDadosGnre->appendChild($codigo);
            if( $guia->tipo !== NULL )                              $tDadosGnre->appendChild($tipo);
            if( $guia->valor !== NULL )                             $tDadosGnre->appendChild($valor);
            $guias->appendChild($tDadosGnre);
        }
    }

    private function getFooter($lote)
    {
        $this->dom->appendChild($lote);
        $this->xml = $this->dom->saveXML();
    }

    /**
     * Método utilizado para armazenar a guia desejada na classe
     * @param \SGnre\Guia  $guia  Um objeto do tipo Guia
     */
    public function addGuia(\SGnre\Guia $guia)
    {
        //VALIDAÇAO DA GUIA
        if( $guia->c01_ufFavorecida === NULL ) throw new \InvalidArgumentException("O campo 'c01_ufFavorecida' não pode ser NULL");
        if( $guia->c02_receita === NULL ) throw new \InvalidArgumentException("O campo 'c02_receita' não pode ser NULL");
        if( $guia->c14_dataVencimento === NULL ) throw new \InvalidArgumentException("O campo 'c14_dataVencimento' não pode ser NULL");
        if( $guia->c33_dataPagamento === NULL ) throw new \InvalidArgumentException("O campo 'c33_dataPagamento' não pode ser NULL");
        if( $guia->c27_tipoIdentificacaoEmitente !== NULL ){
            if( $guia->c27_tipoIdentificacaoEmitente !== 1 || $guia->c27_tipoIdentificacaoEmitente !== 2 ){
                throw new \InvalidArgumentException("O campo 'c27_tipoIdentificacaoEmitente' só aceitas os valores 1 = CNPJ ou 2 = CPF");
            }
        }



        //VALIDAÇÃO DA GUIA POR ESTADO
        $uf = "\\SGnre\\Estados\\".$guia->c01_ufFavorecida;

        $estado = new $uf;
        $estado->validar($guia);

        $this->guias[] = $guia;
    }

    /*
     * Esse metodo faz a impressão do XML no formato XML
     */
    public function printXml()
    {
        $lote = $this->getHeader();
        $this->getBody($lote);
        $this->getFooter($lote);
        header('Content-type: text/xml');
        echo $this->xml;
    }

    /*
     * Esse metodo faz o download do XML
     */
    public function saveXml()
    {
        $lote = $this->getHeader();
        $this->getBody($lote);
        $this->getFooter($lote);
        header('Content-type: text/xml');
        header('Content-Disposition: attachment; filename="text.xml"');
        echo $this->xml;
    }
}