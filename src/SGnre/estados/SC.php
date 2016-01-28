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

    public function validarReceita($receita)
    {
        if( !in_array($receita, $this->receita) ){
            throw new \InvalidArgumentException("Essa receita não é valida para SC");
        }
    }
}