<?php

namespace SGnre\estados;

abstract class Estados
{
    private $receita = array();
    private $produto = array();


    public function validar(\SGnre\Guia $guia)
    {
    }

    private function validarDetalhmentoReceita(\SGnre\Guia $guia)
    {
    }

    private function validarReceita($receita)
    {
    }

    private function validarProduto(\SGnre\Guia $guia)
    {
    }

    private function validarNumeroDocumentoOrigem(\SGnre\Guia $guia)
    {
    }

    private function validarOutras(\SGnre\Guia $guia)
    {
    }
}