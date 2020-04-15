<?php

require_once 'rb-mysql.php';
R::setup('mysql:host=db;dbname=fl',
    'root', 'testfl');
include_once 'Inn.php';

$inn = $_POST['inn'];

$valid = Inn::validateInn($inn, $error_message, $error_code);

if (!$valid) {
    echo json_encode(['result' => $valid, 'err_msg' => $error_message]);
} else {
    $inBase = Inn::inBase($inn);
    echo json_encode(['result' => $inBase, 'err_msg' => null]);
}
