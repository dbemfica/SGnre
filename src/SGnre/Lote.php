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

            $c1 = $this->dom->createElement("c01_ufFavorecida",$guia->c01_ufFavorecida);
            $c2 = $this->dom->createElement("c02_receita",$guia->c02_receita);
            $c4 = $this->dom->createElement("c04_docOrigem",$guia->c04_docOrigem);
            $c6 = $this->dom->createElement("c06_valorPrincipal",$guia->c06_valorPrincipal);
            $c14 = $this->dom->createElement("c14_dataVencimento",$guia->c14_dataVencimento);
            $c17 = $this->dom->createElement("c17_inscricaoEstadualEmitente",$guia->c17_inscricaoEstadualEmitente);
            $c28 = $this->dom->createElement("c28_tipoDocOrigem",$guia->c28_tipoDocOrigem);
            $c33 = $this->dom->createElement("c33_dataPagamento",$guia->c33_dataPagamento);
            $c36 = $this->dom->createElement("c36_inscricaoEstadualDestinatario",$guia->c36_inscricaoEstadualDestinatario);

            if( !empty($guia->c39_campoExtra) ){
                $c39 = $this->dom->createElement("c39_campoExtra");
                $c39_aux = $this->dom->createElement("campoExtra");
                foreach( $guia->c39_campoExtra as $k => $v ){
                    $aux = $this->dom->createElement($k,$v);
                    $c39_aux->appendChild($aux);
                }
                $c39->appendChild($c39_aux);
            }

            $tDadosGnre->appendChild($c1);
            $tDadosGnre->appendChild($c2);
            $tDadosGnre->appendChild($c4);
            $tDadosGnre->appendChild($c6);
            $tDadosGnre->appendChild($c14);
            $tDadosGnre->appendChild($c17);
            $tDadosGnre->appendChild($c28);
            $tDadosGnre->appendChild($c33);
            $tDadosGnre->appendChild($c36);
            $tDadosGnre->appendChild($c39);
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
        if( $guia->c01_ufFavorecida === NULL ) throw new \InvalidArgumentException("O campo 'c01_ufFavorecida' não ser NULL");
        if( $guia->c02_receita === NULL ) throw new \InvalidArgumentException("O campo 'c02_receita' não ser NULL");
        if( $guia->c14_dataVencimento === NULL ) throw new \InvalidArgumentException("O campo 'c14_dataVencimento' não ser NULL");
        if( $guia->c33_dataPagamento === NULL ) throw new \InvalidArgumentException("O campo 'c33_dataPagamento' não ser NULL");

        //VALIDAÇÃO DA GUIA POR ESTADO
        $uf = "\\SGnre\\Estados\\".$guia->c01_ufFavorecida;

        $estado = new $uf;
        $estado->validarReceita($guia->c02_receita);

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