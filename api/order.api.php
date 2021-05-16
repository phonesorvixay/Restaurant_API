<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

include "../controllers/order.controller.php";
include_once "../models/order.model.php";
try {

    Initialization();
    $m = GetMethod();

    $json = json_decode(file_get_contents('php://input'), true);

    $control = new OrderController();

    if ($m == "addorder") {
        $tk = new OrderModel($json['order']);
        $tk->validateTid();
        $control->addOrder($tk, $json['list_order']);
    } else if ($m == "updateorder") {
        $tk = new OrderModel($json['order']);
        $tk->validateTid();
        $control->updateOrder($tk, $json['list_order']);
    } else if ($m == "invoice") {
        $tk = (object) $json;
        $control->invoice($tk);
    } else if ($m == "payment") {
        $tk = (object) $json;
        $control->payment($tk);
    } else if ($m == "orderlist") {
        $tk = (object) $json;
        $control->orderList($tk);
    } else if ($m == "getorder") {
        $inv = (object) $json;
        $control->getorder($inv);
    } else if ($m == "getorderByTable") {
        $inv = (object) $json;
        $control->getorderBayTable($inv);
    } else {
        PrintJSON("", "method not provided", 0);
    }
} catch (Exception $e) {
    print_r($e);
}
