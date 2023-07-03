<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'function.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contact = new Contact();
    $result = $contact->contactUs($_POST);

    if ($result) {
        echo 'Data inserted successfully';
    } else {
        echo 'Error occurred during data insertion';
    }
}