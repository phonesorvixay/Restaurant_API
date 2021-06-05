<?php
include "../services/services.php";
include 'database.controller.php';
class UserController
{
    public function __construct()
    {
    }
    public function addUser($u)
    {
        try {
            $db = new DatabaseController();
            $sql = "insert into users (user_name,user_password,role) values ('$u->username','$u->password','$u->role')";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "add user OK!", 1);
            } else {
                PrintJSON("", "add user failed!", 0);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function updateUser($u)
    {
        try {
            $db = new DatabaseController();

            $sql = "update users set user_name='$u->username',user_password='$u->password',role='$u->role' where user_id ='$u->user_id' ";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "update user OK!", 1);
            } else {
                PrintJSON("", "update user failed!", 0);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function deleteUser($u)
    {
        try {
            $db = new DatabaseController();
            $sql = "select * from `order` where user_id='$u->user_id' ";
            $name = $db->query($sql);

            if ($name > 0) {
                PrintJSON("", " user ID: " . $u->user_id . " have foreign key in order", 0);
                die();
            }
            $sql = "delete from users where user_id='$u->user_id'";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "user ID: " . $u->user_id . " delete Ok", 1);
            } else {
                PrintJSON("", "delete user failed!", 0);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function changePassword($u)
    {
        try {
            $db = new DatabaseController();
            $sql = "update users set user_password = '$u->new_password' where user_id='$u->user_id'";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "change password Ok!", 1);
            } else {
                PrintJSON("", "change password failed!", 0);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function resetPassword()
    {
        try {
            $db = new DatabaseController();
            $user_id = $_SESSION['uid'];
            $sql = "update users set user_password = '123456' where user_id='$user_id'";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "reset password to: 123456", 1);
            } else {
                PrintJSON("", "change password failed!", 0);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function getuser($get)
    {
        try {

            $db = new DatabaseController();
            $sql = "select * from users where user_id ='$get->user_id' ";
            $data = $db->query($sql);
            $json = json_encode($data[0]);
            echo $json;
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function userList($get)
    {
        try {

            $db = new DatabaseController();

            $offset = (($get->page - 1) * $get->limit);

            $sql = "select * from users ";
            if (isset($get->keyword) && $get->keyword != "") {
                $sql .= "where
                        user_name like '%$get->keyword%'
                          ";
            }
            $sql_page = "order by user_id desc limit $get->limit offset $offset";
            // echo $sql.$sql_page;die();
            $doquery = $db->query($sql);
            if ($doquery > 0) {
                $count = sizeof($doquery);
                if ($count > 0) {
                    $data = $db->query($sql . $sql_page);
                    $list1 = json_encode($data);
                }
            } else {
                $list1 = json_encode([]);
                $count = 0;
            }

            $number_count = $count;
            $total_page = ceil($number_count / $get->limit);
            $list3 = json_encode($total_page);
            $json = "{  \"Data\":$list1,
                        \"Page\":$get->page,
                        \"Pagetotal\":$list3,
                        \"Datatotal\":$number_count
                    }";
            echo $json;
        } catch (Exception $e) {
            print_r($e);
        }
    }
}
