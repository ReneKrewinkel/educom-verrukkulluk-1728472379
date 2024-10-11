<?php

class kitchenType {

    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }
  
    public function selecteerKT($kt_id) {

        $sql = "select * from keuken_type where id = $kt_id";
        
        $result = mysqli_query($this->connection, $sql);
        $kt = mysqli_fetch_array($result, MYSQLI_ASSOC);

        return($kt);

    }


}
