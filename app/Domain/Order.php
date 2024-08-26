<?php

namespace laundry\Domain;

class Order{
    
    public $semua = [];
    public int $id;
    public int $customer_id;
    public string $order_date;
    public int $total_amount;
    public ?string $status = null;
    
}