<?php
require_once "../../vendor/autoload.php";

$guia = new \SGnre\Guia();
$guia->c01_UfFavorecida = "SC";
$guia->c02_receita = 100099;
$guia->c26_produto = 49;
$guia->c27_tipoIdentificacaoEmitente = 1;
$guia->c03_idContribuinteEmitente = '05698745000145';
$guia->c28_tipoDocOrigem = '10';
$guia->c04_docOrigem = '5712';
$guia->c10_valorTotal = '10.00';
$guia->c14_dataVencimento = '2016-02-20';
$guia->c16_razaoSocialEmitente = 'Empresa Teste';
$guia->c18_enderecoEmitente = 'Rua teste';
$guia->c19_municipioEmitente = '17608';
$guia->c20_ufEnderecoEmitente = 'RS';
$guia->c33_dataPagamento = '2016-02-20';

$extra = array(
    0 => array(
        'codigo' => 96,
        'tipo' => 'T',
        'valor' => '43160105556927000126550010000026161875976560'
    )
);
$guia->c39_camposExtras = $extra;

$lote = new \SGnre\Lote();
$lote->addGuia($guia);
$lote->printXml();

//Se quiser fazer o download comente o metodo print e descomente este aqui
//$lote->saveXml();