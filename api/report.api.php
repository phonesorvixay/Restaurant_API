<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

include_once "../controllers/report.controller.php";
try {

    Initialization();
    $m = GetMethod();

    $json = json_decode(file_get_contents('php://input'), true);
    $tk = (object) $json;
    $control = new ReportTicketController();

    if ($m == "reportOrder") {
        $control->reportOrder($tk);
    } else if ($m == "reportReceives") {
        $control->reportReceives($tk);
    } else {
        PrintJSON("", "method not provided", 0);
    }
} catch (Exception $e) {
    print_r($e);
}
