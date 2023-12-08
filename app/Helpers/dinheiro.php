<?php

function converteCentavos(float $valor):int
{
    return $valor * 100;
}

function converteReais(int $valor):float
{
    $valor = $valor/100;
    return (float)number_format($valor, 2, ",", ".");
}
