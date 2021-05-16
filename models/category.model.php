<?php

class CategoryModel
{
    public $c_id;
    public $c_name;
  
    public $page;
    public $limit;
    public $keyword;
    public function __construct($object)
    {
        // print_r($object);die();
        if (!$object) {
            echo '{"message":" data is empty"}';
            die();
        }
        foreach ($object as $property => $value) {
            if (property_exists('CategoryModel', $property)) {
                $this->$property = $value;
            }
        }
    }
    public function checkId()
    {
        $db = new DatabaseController();
        $sql = "select * from category where c_id='$this->c_id' ";
        $name = $db->query($sql);
        
        if ($name == 0) {
            PrintJSON(""," category ID: ".$this->c_id. " is not available!", 0);
            die();
        } 
    }
    public function checkdelete()
    {
        $db = new DatabaseController();
        $sql = "select * from food where c_id='$this->c_id' ";
        $name = $db->query($sql);
        
        if ($name > 0) {
            PrintJSON(""," category ID: ".$this->c_id. " have foreign key in food", 0);
            die();
        } 
    }
    function validatec_name()
    {
        $db = new DatabaseController();
        $sql = "select * from category where c_name='$this->c_name' and c_id!='$this->c_id' ";
        $name = $db->query($sql);
        
        if ($name > 0) {
            PrintJSON(""," category name: ".$this->c_name. " is already exist!", 0);
            die();
        } 
        if (empty($this->c_name)) {
            PrintJSON("", "category name is empty!", 0);
            die();
        }
    }

}
