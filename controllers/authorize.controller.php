<?php

include "../services/services.php";
include_once '../services/common.inc.php';
include 'database.controller.php';

class LoginController
{

    public function __construct()
    {
    }

    public function checkLogin($u)
    {
        $db = new DatabaseController();
        $sql = "select * from users where user_name='$u->username' and user_password='$u->password' ";
        $sql1 = "select user_id,user_name,role from users where user_name='$u->username' and user_password='$u->password' ";
        $name = $db->query($sql);
        $list = $db->query($sql1);
        $row = $name[0];
        if ($name > 0) {
            echo json_encode(array(
                'status' => "1",
                'token' => registerToken($row),
                'data' => $list[0],
            ));
        } else {

            $sql = "select * from users where user_name='$u->username'";
            $name = $db->query($sql);

            $sql1 = "select * from users where user_password='$u->password'";
            $pass = $db->query($sql1);

            if ($name == 0 && $pass == 0) {
                PrintJSON("", "Wrong username and password!!!", 0);
            } else if ($name > 0 && $pass == 0) {
                PrintJSON("", "Wrong password!!!", 0);
            } else if ($name == 0 && $pass > 0) {
                PrintJSON("", "Wrong username!!!", 0);
            } else if ($name > 0 && $pass > 0) {
                PrintJSON("", "Wrong username or password!!!", 0);
            }
        }
    }
}
