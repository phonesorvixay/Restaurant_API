<?php
include "../services/services.php";
include 'database.controller.php';
class TableController
{
    public function __construct()
    {
    }
    public function addTable($get)
    {
        try {
            $db = new DatabaseController();
            $sql = "insert into `table` (table_number) values ('$get->table_number')";
            $data = $db->query($sql);   
            if ($data) {
                PrintJSON("", "add table OK!", 1);
            } else {
                PrintJSON("", "add table failed!", 0);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function updateTable($get)
    {
        try {
            $db = new DatabaseController();
            $sql = "update `table` set table_number='$get->table_number' where t_id='$get->t_id'";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "update table OK!", 1);
            } else {
                PrintJSON("", "update table failed!", 0);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function deleteTable($get)
    {
        try {
            $db = new DatabaseController();
            $sql = "delete from `table` where t_id='$get->t_id'";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "table ID: " . $get->t_id. " delete Ok", 1);
            } else {
                PrintJSON("", "delete table failed!", 0);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function tableList($get)
    {
        try {
            $db = new DatabaseController();

            if ($get->page == "" && $get->limit == "") {
                $sql = "select * from `table`  order by t_id desc ";
                $doquery = $db->query($sql);
                $list = json_encode($doquery);
                $json = "{\"Data\":$list}";
                echo $json;
            } else {
                $offset = (($get->page - 1) * $get->limit);

                $sql = "select * from `table`  ";
                if (isset($get->keyword) && $get->keyword != "") {
                    $sql .= "where
                        table_number like '%$get->keyword%' 
                          ";
                }
                $sql_page = "order by t_id desc limit $get->limit offset $offset  ";
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
    public function getTable($get)
    {
        try {
            $db = new DatabaseController();

                $sql = "select * from `table`  where t_id ='$get->t_id' ";
                $data = $db->query($sql);
                $list = json_encode($data);
                echo $list;
            
        } catch (Exception $e) {
            print_r($e);
        }

    }
}
