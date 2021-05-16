<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

include "../controllers/food.controller.php";
include_once "../models/food.model.php";

try {
    Initialization();
    $m = getallheaders()['m'];

    $json = json_decode(file_get_contents('php://input'), true);
    $control = new FoodController();
    $model = new FoodModel($json);

    if ($m == "addfood") {
        $model->validateF_name();
        $model->validatePrice();
        $control->addfood($model);
    } else if ($m == "updatefood") {
        $model->checkId();
        $model->validateF_name();
        $model->validatePrice();
        $control->updatefood($model);
    } else if ($m == "deletefood") {
        $model->checkId();
        $control->deletefood($model);
    } else if ($m == "foodlist") {
        $control->foodList($model);
    } else if ($m == "getfood") {
        $control->getfood($model);
    } else {
        PrintJSON("", "wrong method!!!", 0);
    }
} catch (Exception $e) {
    print_r($e);
}
