<?php

class OrderModel
{
    public $order_id;
    public $t_id;

    public $page;
    public $limit;
    public $keyword;

    public function __construct($object)
    {
        if (!$object) {
            PrintJSON("", "data is empty!", 0);
            die();
        }
        foreach ($object as $property => $value) {
            if (property_exists('OrderModel', $property)) {
                $this->$property = $value;
            }
        }
    }
    public function validateTid()
    {
        $db = new DatabaseController();
        $sql = "select * from `table` where t_id='$this->t_id' and status != 1 ";
        $name = $db->query($sql);
            
        if ($name == 0) {
            PrintJSON(""," Table ID: ".$this->t_id. " is opening", 0);
            die();
        } 
        if (empty($this->t_id)) {
            PrintJSON("", "tid is empty", 0);
            die();
        }
    }
}
