<?php

namespace laundry\Repository;

use Exception;
use laundry\Domain\OrderDetails;
use PDO;

class OrderDetailsRepository{

    private \PDO $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function save(OrderDetails $customer): OrderDetails
    {

        try{

            $statement = $this->connection->prepare("insert into order_details(order_id,item_name,quantity, price) values(?,?,?,?)");
            $statement->execute([$customer->order_id, $customer->item_name, $customer->quantity, $customer->price]);
            return $customer;

        }catch(Exception $ex){

            throw $ex;

        }
        

    }
}