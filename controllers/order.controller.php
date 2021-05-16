<?php

include "../services/services.php";
include 'database.controller.php';
require_once "databasePDO.controller.php";

class OrderController
{

    public function __construct()
    {
    }
    public function addOrder($tk, $dt)
    {
        try {
            $db = new PDODBController();

            date_default_timezone_set("Asia/Vientiane");
            $user_id = $_SESSION["uid"];
            $date_now = date("Y-m-d");

            $db->beginTran();

            $sql = "insert into `order` (user_id,t_id,order_date,status)
                    values ('$user_id','$tk->t_id','$date_now',0)";
            $db->query($sql);
            $ID = $db->lastID();
            $subsql = "insert into list_order (order_id,f_id,lo_qty,price) values";
            for ($i = 0; $i < sizeof($dt); $i++) {
                $f_id = $dt[$i]['product_id'];
                $lo_qty = $dt[$i]['quantity'];
                $price = $dt[$i]['price'];

                if ($i == sizeof($dt) - 1) {
                    $subsql .= "($ID,'$f_id','$lo_qty','$price')";
                } else {
                    $subsql .= "($ID,'$f_id','$lo_qty','$price'),";
                }
            }
            // echo $subsql;die();
            $db->query($subsql);

            $sql = "update `table` set status=1 where t_id='$tk->t_id'";
            $db->query($sql);

            $db->commit();

            echo json_encode(array("order_id" => "$ID", "message" => "add order ok", "status" => "1"));
        } catch (Exception $e) {
            $db->rollback();
            PrintJSON("", "add order fail error: " . $e->getMessage(), 0);
        }
    }
    public function updateOrder($tk, $dt)
    {
        try {
            $db = new PDODBController();

            $db->beginTran();

            $sql = "update `order` set t_id='$tk->t_id' where order_id='$tk->order_id' ";
            $db->query($sql);

            $sql = "delete from list_order where order_id='$tk->order_id' ";
            $db->query($sql);

            $subsql = "insert into list_order (order_id,f_id,lo_qty,price) values";
            for ($i = 0; $i < sizeof($dt); $i++) {
                $f_id = $dt[$i]['product_id'];
                $lo_qty = $dt[$i]['quantity'];
                $price = $dt[$i]['price'];

                if ($i == sizeof($dt) - 1) {
                    $subsql .= "('$tk->order_id','$f_id','$lo_qty','$price')";
                } else {
                    $subsql .= "('$tk->order_id','$f_id','$lo_qty','$price'),";
                }
            }
            $db->query($subsql);

            $db->commit();

            PrintJSON("", "update order Ok", 1);
        } catch (Exception $e) {
            $db->rollback();
            PrintJSON("", "add order fail error: " . $e->getMessage(), 0);
        }
    }
    public function invoice($tk)
    {
        try {
            $db = new DatabaseController();
            $sql = "update `order` set status = 1 where order_id='$tk->order_id'";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "Invoice OK!", 1);
            } else {
                PrintJSON("", "Invoice failed!", 0);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function payment($tk)
    {
        try {
            $db = new PDODBController();

            $db->beginTran();

            $sql = "update `table` set status = 0 where t_id='$tk->t_id'";
            $db->query($sql);
            // echo "query1 =>$sql";
            $sql = "update `order` set status = 2 where order_id='$tk->order_id'";
            $db->query($sql);
            // echo "query 2 => $sql";
            $db->commit();

            PrintJSON("", "Payment OK!", 1);
        } catch (Exception $e) {
            print_r($e);
            PrintJSON("", "Payment failed!", 0);
        }
    }
    public function orderList($get)
    {
        try {
            $db = new DatabaseController();

            if ($get->page == "" && $get->limit == "") {
                $sql = "select order_id,user_id,o.t_id,t.table_number,order_date 
                        from `order` as o 
                        INNER JOIN `table` as t ON o.t_id=t.t_id order by order_id desc";
                $doquery = $db->query($sql);
                $list = json_encode($doquery);
                $json = "{\"Data\":$list}";
                echo $json;
            } else {
                $offset = (($get->page - 1) * $get->limit);

                $sql = "select order_id,user_id,o.t_id,t.table_number,order_date 
                from `order` as o 
                INNER JOIN `table` as t ON o.t_id=t.t_id ";
                if (isset($get->keyword) && $get->keyword != "") {
                    $sql .= "where
                        order_id like '%$get->keyword%' or
                        user_id like '%$get->keyword%' or
                        table_number like '%$get->keyword%' 
                          ";
                }
                $sql_page = "order by order_id desc limit $get->limit offset $offset  ";
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
    public function getorder($order)
    {
        try {
            $db = new DatabaseController();
            $sql1 = "select order_id,user_id,o.t_id,t.table_number,order_date 
                    from `order` as o 
                    INNER JOIN `table` as t ON o.t_id=t.t_id
                    where order_id='$order->order_id'";
            $data1 = $db->query($sql1);

            $list1 = json_encode($data1[0]);

            $sql2 = "select lo_id,order_id,l.f_id as product_id,f_name as product_name, lo_qty as quantity, l.price,(lo_qty*l.price) as total
                    from list_order as l
                    INNER JOIN food as f ON l.f_id = f.f_id
                    where order_id='$order->order_id' ";
            $data2 = $db->query($sql2);
            $list2 = json_encode($data2);

            $json = "{ \"order\":$list1,
                      \"list_order\":$list2
                      }";
            echo $json;
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function getorderBayTable($order)
    {
        try {
            $db = new DatabaseController();
            $sql1 = "select order_id ,user_id,o.t_id,t.table_number,order_date 
                    from `order` as o
                    INNER JOIN `table` as t ON o.t_id=t.t_id
                    where o.status IN(0,1) and o.t_id='$order->t_id'";
            $data1 = $db->query($sql1);
            $orderid = $data1[0]['order_id'];
            $list1 = json_encode($data1);

            $sql2 = "select lo_id,order_id,l.f_id as product_id,f_name as product_name, lo_qty as quantity, l.price,(lo_qty*l.price) as total
                     from list_order as l
                     INNER JOIN food as f ON l.f_id = f.f_id
                     where order_id='$orderid'";
            $data2 = $db->query($sql2);
            $list2 = json_encode($data2);

            $json = "{ \"order\":$list1,
                      \"list_order\":$list2
                      }";
            echo $json;
        } catch (Exception $e) {
            print_r($e);
        }
    }
}
