<?php

require_once __DIR__.'/boot.php';

$file = simplexml_load_file('https://www.cbr.ru/scripts/XML_daily.asp?date_req='.date('d/m/Y'));
$currience['USD'] = $file->xpath("//Valute[@ID='R01235']");
$currience['EUR'] = $file->xpath("//Valute[@ID='R01239']");
$currience['CNY'] = $file->xpath("//Valute[@ID='R01375']");

foreach ($currience as $k => $v) {
    $stmt = pdo()->prepare("UPDATE `currencies` SET `value` = :value WHERE `name` = :name");
    $stmt->execute([
        'value' => floatval($v[0]->Value),
        'name' => $k,
    ]);
}