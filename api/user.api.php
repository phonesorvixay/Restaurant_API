<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

include "../controllers/user.controller.php";
include_once "../models/user.model.php";

try {
    Initialization();
    $m = getallheaders()['m'];

    $json = json_decode(file_get_contents('php://input'), true);
    $control = new UserController();

    if ($m == "adduser") {
        $model = new UserModel($json);
        $model->validateall();
        $control->addUser($model);
    } else if ($m == "deleteuser") {
        $model = new UserModel($json);
        $model->checkId();
        $control->deleteUser($model);
    } else if ($m == "changepassword") {
        $model = new UserModel($json);
        $model->validatePassword();
        $control->changePassword($model);
    } else if ($m == "userlist") {
        $model = new UserModel($json);
        $control->userList($model);
    } else if ($m == "resetpassword") {
        $control->resetPassword();
    } else if ($m == "getuser") {
        $model = new UserModel($json);
        $control->getuser($model);
    } else {
        PrintJSON("", "wrong method!!!", 0);
    }
} catch (Exception $e) {
    print_r($e);
}
