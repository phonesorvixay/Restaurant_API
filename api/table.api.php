<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

include "../controllers/table.controller.php";
include_once "../models/table.model.php";

try {
    Initialization();
    $m = getallheaders()['m'];
    $json = json_decode(file_get_contents('php://input'), true);
    $control = new TableController();
    $model = new TableModel($json);

    if ($m == "addtable") {
        $model->validateTableNumber();
        $control->addTable($model);
    } else if ($m == "updatetable") {
        $model->checkId();
        $model->validateTableNumber();
        $control->updateTable($model);
    } else if ($m == "deletetable") {
        $model->checkId();
        $control->deleteTable($model);
    } else if ($m == "tablelist") {
        $control->tableList($model);
    } else if ($m == "gettable") {
        $control->gettable($model);
    } else {
        PrintJSON("", "wrong method!!!", 0);
    }
} catch (Exception $e) {
    print_r($e);
}
