<?php
include "../services/services.php";
include 'database.controller.php';
require_once "databasePDO.controller.php";
class CategoryController
{
    public function __construct()
    {
    }
    public function addCategory($cate)
    {
        try {
            $db = new DatabaseController();

            $sql = "insert into category (c_name) values ('$cate->c_name')";
            $data = $db->query($sql);   
            if ($data) {
                PrintJSON("", "add category OK!", 1);
            } else {
                PrintJSON("", "add category failed!", 0);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function updateCategory($cate)
    {
        try {
            $db = new DatabaseController();

            $sql = "update category set c_name='$cate->c_name' where c_id ='$cate->c_id' ";
            $data = $db->query($sql);   
            if ($data) {
                PrintJSON("", "update category OK!", 1);
            } else {
                PrintJSON("", "update category failed!", 0);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function deleteCategory($cate)
    {
        try {
            $db = new DatabaseController();
 
            $sql = "delete from category where c_id='$cate->c_id'";
            $data = $db->query($sql);   
            if ($data) {
                PrintJSON("", "category ID: " . $cate->c_id. " delete Ok", 1);
            } else {
                PrintJSON("", "delete category failed!", 0);
            }
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
    }
    public function categoryList($get)
    {
        try {
            $db = new DatabaseController();

            if ($get->page == "" && $get->limit == "") {
                $sql = "select *from category order by c_id desc ";
                $doquery = $db->query($sql);

                $list = json_encode($doquery);
                $json = "{\"Data\":$list}";
                echo $json;
            } else {
                $offset = (($get->page - 1) * $get->limit);

                $sql = "select * from category ";
                if (isset($get->keyword) && $get->keyword != "") {
                    $sql .= "where
                        c_name like '%$get->keyword%'
                          ";
                }
                $sql_page = "order by c_id desc limit $get->limit offset $offset  ";
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
    public function getCategory($cate)
    {
        try {
            $db = new DatabaseController();
            $sql1 = " select* from category where c_id='$cate->c_id'";
            $data = $db->query($sql1);
            $list = json_encode($data);
            echo $list;

        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function categoryParent()
    {
        try {
            $db = new DatabaseController();
            $sql1 = " select * from category ";
            $data1 = $db->query($sql1);
            
            $row = $data1 > 0 ? count($data1) : "";
            for ($i = 0; $i < $row; $i++) {
                $cate_id = $data1[$i]['c_id'];
                $sql2 = "select * from food where c_id ='$cate_id' ";
                $data2 = $db->query($sql2);
            
                $data1[$i]["menu"] = $data2;
            }
            
            $list = json_encode($data1);
            
            echo $list;

        } catch (Exception $e) {
            print_r($e);
        }
    }
}
