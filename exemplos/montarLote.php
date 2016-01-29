<?php
require_once "../vendor/autoload.php";

$guia = new \SGnre\Guia();
$guia->c01_ufFavorecida = "SC";
$guia->c02_receita = 100099;
$guia->c04_docOrigem = 6487;
$guia->c06_valorPrincipal = 269.50;
$guia->c14_dataVencimento = '2015-10-16';
$guia->c17_inscricaoEstadualEmitente = 1140037126;
$guia->c26_produto = 46;
$guia->c28_tipoDocOrigem = 10;
$guia->c33_dataPagamento = '2015-10-16';
$guia->c36_inscricaoEstadualDestinatario = 1140037126;


$campoExtra['codigo'] = 91;
$campoExtra['tipo'] = 'T';
$campoExtra['valor'] = '43151002032675000148550010000064871000064870';

$guia->c39_campoExtra = $campoExtra;

$lote = new \SGnre\Lote();
$lote->addGuia($guia);
$lote->printXml();