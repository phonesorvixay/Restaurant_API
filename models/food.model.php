<?php

class FoodModel
{
    public $f_id;
    public $c_id;
    public $f_name;
    public $price;
    public $f_detail;

    public $page;
    public $limit;
    public $keyword;
    public function __construct($object)
    {
        if (!$object) {
            echo '{"message":" data is empty"}';
            die();
        }
        foreach ($object as $property => $value) {
            if (property_exists('FoodModel', $property)) {
                $this->$property = $value;
            }
        }
    }
    public function checkId()
    {
        $db = new DatabaseController();
        $sql = "select * from food where f_id='$this->f_id' ";
        $name = $db->query($sql);

        if ($name == 0) {
            PrintJSON("", " food ID: " . $this->f_id . " is not available!", 0);
            die();
        }
    }

    public function validateF_name()
    {
        $db = new DatabaseController();
        $sql = "select * from food where f_name='$this->f_name' and f_id!='$this->f_id' ";
        $name = $db->query($sql);

        if ($name > 0) {
            PrintJSON("", " food name: " . $this->f_name . " already exist!", 0);
            die();
        }
        if(empty($this->f_name)){
            PrintJSON("","food name is empty!",0);
            die();
        }
    }
    public function validatePrice(){
        if(empty($this->price)){
            PrintJSON("","price is empty",0);
            die();
        }
    }

}
