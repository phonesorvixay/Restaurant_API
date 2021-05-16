<?php

class DatabaseController
{

    private $conn;
    private $dbhost = "localhost";
    private $dbuser = "root";
    private $dbpass = "";
    private $dbname = "restaurant";
    private $charset = "utf8";
    protected $show_errors = true;

    public function __construct()
    {
        $this->conn = new mysqli($this->dbhost, $this->dbuser, $this->dbpass, $this->dbname);

        if (!$this->conn) {
            $this->error($this->conn->connect_error);
        }

        $this->conn->set_charset($this->charset);
    }

    public function __destruct()
    {
        $this->conn->close();
    }

    public function query($sql)
    {
        $data = null;
        if (empty($sql)) {
            return false;
        }
        if (!$this->conn) {
            return false;
        }

        $results = $this->conn->query($sql);

        if (!$results) {
            return false;
        }
        if (!(preg_match("/select/i", $sql) || preg_match("/show/i", $sql))) {
            return true;
        } else {
            if (!$results) {
                return $data;
            } else {
                while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
                    $data[] = $row;
                }
                mysqli_free_result($results);
                return $data;
            }
        }
    }

    public function lastID()
    {
        return $this->conn->insert_id;
    }

    public function autocommit()
    {
        return $this->conn->autocommit(false);
    }

    public function commit()
    {
        return $this->conn->commit();
    }

    public function rollback()
    {
        return $this->conn->rollback();
    }

    public function error($error)
    {
        if ($this->show_errors) {
            exit($error);
        }
    }
}
