<?php
require_once __DIR__.'/boot.php';
$data = array();
$stmt = pdo()->prepare("SELECT * FROM `currencies` WHERE `name` = :name");
$stmt->execute(['name' => $_POST['currency']]);
if (!$stmt->rowCount()) {
    $data['error'] = 'Такой валюты нет';
    echo json_encode(['data' => $data]);
    die;
}

$sum = $_POST['sum'];
$currency = $stmt->fetch(PDO::FETCH_ASSOC);
if ($_POST['reserve'] == 'true') {
    $data['sum'] = round(intval($sum) / $currency['value'], 2);
} else {
    $data['sum'] = intval($sum) * $currency['value'];
}
echo json_encode(['data' => $data]);
die;