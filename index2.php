<?php


$valor1 = 1;
$valor2 = 2;

$resultado = $valor1 + $valor2;

echo "El resultado de la suma es: " . $resultado . "\n";


function suma($a, $b) {
    return $a + $b;
}

function showResult($result) {
    if ($result > 10) {
        echo "El resultado es mayor que 10\n";
    } elseif ($result < 10) {
        echo "El resultado es menor que 10\n";
    } else {
        echo "El resultado es igual a 10\n";
    }
    echo "El resultado de la suma es: " . $result . "\n";
}


$result = suma(3, 5);

showResult(suma(2, 4));