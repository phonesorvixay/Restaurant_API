<?php
include "../services/services.php";
include 'database.controller.php';
class foodController
{
    public function __construct()
    {
    }
    public function addfood($get)
    {
        try {
            $db = new DatabaseController();
            $sql = "insert into food (c_id,f_name,price,f_detail) values ('$get->c_id','$get->f_name','$get->price','$get->f_detail')";
            $data = $db->query($sql);   
            if ($data) {
                PrintJSON("", "add food OK!", 1);
            } else {
                PrintJSON("", "add food failed!", 0);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function updatefood($get)
    {
        try {
            $db = new DatabaseController();
            $sql = "update food set c_id='$get->c_id', f_name='$get->f_name',price='$get->price',f_detail='$get->f_detail' where f_id='$get->f_id'";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "update food OK!", 1);
            } else {
                PrintJSON("", "update food failed!", 0);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function deletefood($get)
    {
        try {
            $db = new DatabaseController();
            $sql = "delete from food where f_id='$get->f_id'";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "food ID: " . $get->f_id. " delete Ok", 1);
            } else {
                PrintJSON("", "delete food failed!", 0);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function foodList($get)
    {
        try {
            $db = new DatabaseController();

            if ($get->page == "" && $get->limit == "") {
                $sql = "select f_id,f.c_id,c.c_name,f_name,price,f_detail from food as f
                        INNER JOIN category as c ON f.c_id=c.c_id  order by f_id desc ";
                $doquery = $db->query($sql);
                $list = json_encode($doquery);
                $json = "{\"Data\":$list}";
                echo $json;
            } else {
                $offset = (($get->page - 1) * $get->limit);

                $sql = "select f_id,f.c_id,c.c_name,f_name,price,f_detail from food as f
                        INNER JOIN category as c ON f.c_id=c.c_id  ";
                if (isset($get->keyword) && $get->keyword != "") {
                    $sql .= "where
                        f_id like '%$get->keyword%' or
                        f_name like '%$get->keyword%' or
                        c.c_name like '%$get->keyword%' or
                        price like '%$get->keyword%' 
                          ";
                }
                $sql_page = "order by f_id desc limit $get->limit offset $offset  ";
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
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function getfood($get)
    {
        try {
            $db = new DatabaseController();

                $sql = "select f_id,f.c_id,c.c_name,f_name,price,f_detail from food as f
                        INNER JOIN category as c ON f.c_id=c.c_id  where f_id ='$get->f_id' ";
                $data = $db->query($sql);
                $list = json_encode($data);
                echo $list;
            
        } catch (Exception $e) {
            print_r($e);
        }
    }
}
