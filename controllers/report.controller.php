
<?php

include "../services/services.php";
include 'database.controller.php';
require_once "databasePDO.controller.php";

class ReportTicketController
{
    public function __construct()
    {
    }
    public function reportOrder($get)
    {
        try {
            $db = new DatabaseController();
            $sql1 = "select f_name,sum(lo_qty)as qty,l.price,(sum(lo_qty)*l.price) as total
                    from list_order as l
                    INNER JOIN food as f ON l.f_id = f.f_id
                    INNER JOIN `order` as o ON l.order_id = o.order_id 
                    where order_date between '$get->first_date' and '$get->last_date' group by f_name";
            $data1 = $db->query($sql1);
            $json = json_encode($data1);
            if($data1 > 0){
                echo $json;
            }else{
                echo '[]';
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function reportReceives($get)
    {
        try {
            $db = new DatabaseController();
            $sql1 = "select order_id,user_id,t_id,order_date,
                    (select sum((lo_qty*price)) from list_order as l where l.order_id =o.order_id) as total
                    from `order` as o
                     where order_date between '$get->first_date' and '$get->last_date'";
            $data1 = $db->query($sql1);
            $json = json_encode($data1);
            if($data1 > 0){
                echo $json;
            }else{
                echo '[]';
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
}
