<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

include "../controllers/category.controller.php";
include_once "../models/category.model.php";

try {
    Initialization();
    $m = getallheaders()['m'];

    $json = json_decode(file_get_contents('php://input'), true);
    $control = new CategoryController();

    if ($m == "addcategory") {
        $model = new CategoryModel($json);
        $model->validateC_name();
        $control->addCategory($model);
    } else if ($m == "updatecategory") {
        $model = new CategoryModel($json);
        $model->checkId();
        $model->validateC_name();
        $control->updateCategory($model);
    } else if ($m == "deletecategory") {
        $model = new CategoryModel($json);
        $model->checkdelete();
        $control->deleteCategory($model);
    } else if ($m == "categorylist") {
        $model = new CategoryModel($json);
        $control->categoryList($model);
    } else if ($m == "getcategory") {
        $model = new CategoryModel($json);
        $control->getCategory($model);
    }  else if ($m == "categoryparent") {
        $control->categoryParent();
    }else {
        PrintJSON("", "wrong method!!!", 0);
    }
} catch (Exception $e) {
    print_r($e);
}
