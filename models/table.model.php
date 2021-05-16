<?php

class TableModel
{
    public $t_id;
    public $table_number;
    public $status;

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
            if (property_exists('TableModel', $property)) {
                $this->$property = $value;
            }
        }
    }
    public function checkId()
    {
        $db = new DatabaseController();
        $sql = "select * from `table` where t_id='$this->t_id' ";
        $name = $db->query($sql);

        if ($name == 0) {
            PrintJSON("", " table ID: " . $this->t_id . " is not available!", 0);
            die();
        }
    }

    public function validateTableNumber()
    {
        $db = new DatabaseController();
        $sql = "select * from `table` where table_number='$this->table_number' and t_id!='$this->t_id' ";
        $name = $db->query($sql);

        if ($name > 0) {
            PrintJSON("", " tabe name: " . $this->table_number . " already exist!", 0);
            die();
        }
        if(empty($this->table_number)){
            PrintJSON("","Table number is empty!",0);
            die();
        }
    }
}
