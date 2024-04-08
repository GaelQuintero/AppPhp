<?php

// Ejemplo de llamada a una función del contrato
$result = $contract->getAcademicRecord('0x5B38Da6a701c568545dCfcB03FcB875f56beddC4');
echo "Resultado de getAcademicRecord: \n";
foreach ($result as $key => $value) {
    echo $key . ": " . $value . "\n";
}


// Ejemplo de llamada a una función que modifica el estado del contrato
$web3->personal->unlockAccount('0x5B38Da6a701c568545dCfcB03FcB875f56beddC4', 'password'); // Desbloquear una cuenta
$contract->addAcademicRecord('Student Name', [90, 85, 95]);


?>




